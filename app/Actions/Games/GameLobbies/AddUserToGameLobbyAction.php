<?php

namespace App\Actions\Games\GameLobbies;

use App\Enums\Reactions\AddUserToGameLobbyReaction;
use App\Events\GameLobby\GameLobbyPrizeUpdatedEvent;
use App\Events\GameLobby\GameLobbyUserJoinedGameLobbyEvent;
use App\Models\ChatRoomUser;
use App\Models\GameLobby;
use App\Models\GameLobbyUser;
use App\Models\User;
use App\Models\WodoAssetAccount;
use App\Services\Internal\WalletAPI;
use DB;
use Auth;
use Event;
use Cache;
use Illuminate\Support\Facades\Http;
use App\Actions\Wallet\GetUserAssetAccountAction;

class AddUserToGameLobbyAction
{
    public function __construct(
        public GetUserAssetAccountAction $getUserAssetAccountAction,
        protected WalletAPI $walletAPI,
    ) {
    }

    public function execute(User $user, GameLobby $gameLobby)
    {
        return DB::transaction(
            callback: function () use ($user, $gameLobby) {
                $gameLobby = GameLobby::query()
                    ->lockForUpdate()
                    ->findOrFail($gameLobby->id);

                if (!$gameLobby->has_available_spots) {
                    return AddUserToGameLobbyReaction::NoAvailableSpots;
                }

                if (
                    $gameLobby
                        ->users()
                        ->where('users.id', $user->id)
                        ->exists()
                ) {
                    return AddUserToGameLobbyReaction::UserAlreadyJoinedTheGameLobby;
                }

                $userAssetAccount = $this->getUserAssetAccountAction->execute($gameLobby->asset);

                $response = $this->walletAPI->depositToHomeAccount([
                    'fromAccountId' => $userAssetAccount->id,
                    'asset' => $gameLobby->asset->symbol,
                    'amount' => $gameLobby->base_entrance_fee,
                    'refId' => $gameLobby->id,
                ]);

                if ($response->failed()) {
                    return $response->toException();
                }

                $gameLobby->users()->syncWithPivotValues(
                    ids: $user->id,
                    values: [
                        'entrance_fee' => $gameLobby->base_entrance_fee,
                        'joined_at' => now(),
                    ],
                    detaching: false,
                );

                ChatRoomUser::firstOrCreate([
                    'chat_room_id' => $gameLobby->id,
                    'user_id' => $user->id,
                ]);

                $gameLobby->decrement('available_spots');

                //forgeting the user asset account after the balance changed
                Cache::forget('user.' . Auth::id() . '.account' . $gameLobby->asset->symbol);
                Cache::forget('user.' . Auth::id() . '.accounts');

                event(
                    new GameLobbyUserJoinedGameLobbyEvent(
                        gameLobby: $gameLobby,
                        user: $user,
                        entranceFee: $gameLobby->base_entrance_fee,
                    ),
                );
                $total = (float) GameLobbyUser::where('game_lobby_id', $gameLobby->id)->sum('entrance_fee');
                $prize = (float) ($total - ($total * 20.0) / 100.0);
                Event::dispatch(new GameLobbyPrizeUpdatedEvent(gameLobby: $gameLobby, newPrize: $prize));
                return $gameLobby;
            },
        );
    }
}
