<?php

namespace App\Actions\Games\GameLobbies;

use App\Enums\Reactions\AddUserToGameLobbyReaction;
use App\Events\GameLobby\PrizeUpdatedEvent;
use App\Events\GameLobby\UserJoinedGameLobbyEvent;
use App\Models\ChatRoomUser;
use App\Models\GameLobby;
use App\Models\GameLobbyUser;
use App\Models\User;
use App\Models\WodoAssetAccount;
use DB;
use Event;
use Illuminate\Support\Facades\Http;

class AddUserToGameLobbyAction
{
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

                $userAssetAccount = $user
                    ->assetAccounts()
                    ->lockForUpdate()
                    ->where('asset_id', $gameLobby->asset_id)
                    ->first();

                if ($userAssetAccount->balance < $gameLobby->base_entrance_fee) {
                    return AddUserToGameLobbyReaction::InsufficientFunds;
                }

                //here we should call the api
                $asset = $gameLobby->asset()->first();
                $url = config('wodo.wallet-transactions-api') . 'home-deposit';
                $data = [
                    'fromAccountId' => $userAssetAccount->id,
                    'asset' => $asset->symbol,
                    'amount' => $gameLobby->base_entrance_fee,
                    'refId' => $gameLobby->id,
                ];

                $response = Http::post(url: $url, data: $data);
                
                if ($response->failed()) {
                    return $response->toException();
                }

                // return $response->body();

                // $userAssetAccount->decrement('balance', $fee = $gameLobby->base_entrance_fee);

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

                // $wodoAssetAccount = WodoAssetAccount::query()
                //     ->where('asset_id', $gameLobby->asset_id)
                //     ->first();

                // $wodoAssetAccount->increment('balance', $fee);

                $gameLobby->decrement('available_spots');

                broadcast(new UserJoinedGameLobbyEvent(gameLobby: $gameLobby, user: $user, entranceFee: $gameLobby->base_entrance_fee));
                $total = (float) GameLobbyUser::where('game_lobby_id', $gameLobby->id)->sum('entrance_fee');
                $prize = (float) ($total - ($total * 20.0) / 100.0);
                Event::dispatch(new PrizeUpdatedEvent(gameLobby: $gameLobby, newPrize: $prize));
                return $gameLobby;
            },
        );
    }
}
