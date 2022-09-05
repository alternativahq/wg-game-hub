<?php

namespace App\Actions\Games\GameLobbies;

use App\Enums\Reactions\RemoveUserFromGameLobbyReaction;
use App\Events\GameLobby\PrizeUpdatedEvent;
use App\Events\GameLobby\UserLeftGameLobbyEvent;
use App\Models\ChatRoomUser;
use App\Models\GameLobby;
use App\Models\GameLobbyUser;
use App\Models\WodoAssetAccount;
use Auth;
use Cache;
use DB;
use Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RemoveUserFromGameLobbyAction
{
    public function execute(Request $request, GameLobby $gameLobby): GameLobby|RemoveUserFromGameLobbyReaction
    {
        $user = $request->user();
        return DB::transaction(
            callback: function () use ($user, $gameLobby) {
                $gameLobby = GameLobby::query()
                    ->lockForUpdate()
                    ->findOrFail($gameLobby->id);

                if (
                    $gameLobby
                        ->users()
                        ->where('users.id', $user->id)
                        ->doesntExist()
                ) {
                    return RemoveUserFromGameLobbyReaction::UserNotInGameLobby;
                }

                $userAssetAccount = $user
                    ->assetAccounts()
                    ->lockForUpdate()
                    ->where('asset_id', $gameLobby->asset_id)
                    ->first();

                $gameLobbyUser = $gameLobby
                    ->users()
                    ->withPivot('entrance_fee')
                    ->where('user_id', $user->id)
                    ->first();

                $gameLobbyUserEntranceFee = $gameLobbyUser->pivot->entrance_fee;

                // return the amount he paid
                //here we should call the api
                $asset = $gameLobby->asset()->first();
                $url = config('wodo.wallet-transactions-api') . 'home-withdraw';
                $data = [
                    'toAccountId' => $userAssetAccount->id,
                    'asset' => $asset->symbol,
                    'amount' => $gameLobby->base_entrance_fee,
                    'refId' => $gameLobby->id,
                ];
                
                $response = Http::post(url: $url, data: $data);
                
                if ($response->failed()) {
                    return $response->toException();
                }

                // return $response->body();

                // $userAssetAccount->increment('balance', $gameLobbyUserEntranceFee);

                // $wodoAccount = WodoAssetAccount::sharedLock()
                //     ->where('asset_id', $gameLobby->asset_id)
                //     ->first();

                // $wodoAccount->decrement('balance', $gameLobbyUserEntranceFee);

                $gameLobby->increment('available_spots');

                $gameLobby->users()->detach([$user->id]);

                ChatRoomUser::where([['chat_room_id', '=', $gameLobby->id], ['user_id', '=', $user->id]])->delete();

                Cache::forget('user.' . Auth::id() . '.current-lobby-session');

                Event::dispatch(new UserLeftGameLobbyEvent(gameLobby: $gameLobby, user: $user));

                $total = (float) GameLobbyUser::where('game_lobby_id', $gameLobby->id)->sum('entrance_fee');
                $prize = (float) ($total - ($total * 20.0) / 100.0);

                Event::dispatch(new PrizeUpdatedEvent(gameLobby: $gameLobby, newPrize: $prize));

                $user->update([
                    'cooldown_end_at' => now()->addMinutes(2),
                ]);

                return $gameLobby;
            },
        );
    }
}
