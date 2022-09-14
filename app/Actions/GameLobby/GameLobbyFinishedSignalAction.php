<?php

namespace App\Actions\GameLobby;

use App\DataTransferObjects\GameMatchResultData;
use App\Enums\GameLobbyStatus;
use App\Models\GameLobby;
use Illuminate\Support\Facades\Http;

class GameLobbyFinishedSignalAction
{
    public function execute(
        GameLobby $gameLobby,
        GameMatchResultData $gameMatchResultData,
    ): \Illuminate\Http\Client\Response {
        $gameLobby->status = GameLobbyStatus::DistributingPrizes;
        $gameLobby->save();
        $url = config('wodo.game-lobby-service-api') . '/lifecycle/' . $gameLobby->id;
        return Http::retry(5, 1000)->post($url, [
            'action' => 'DISTRIBUTE_PRIZE',
            'params' => $gameMatchResultData->scores,
        ]);
    }
}
