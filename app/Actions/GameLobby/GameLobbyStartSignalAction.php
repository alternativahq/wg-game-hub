<?php

namespace App\Actions\GameLobby;

use App\Models\GameLobby;
use Illuminate\Support\Facades\Http;

class GameLobbyStartSignalAction
{
    public function execute(GameLobby $gameLobby): \Illuminate\Http\Client\Response|\GuzzleHttp\Promise\PromiseInterface
    {
        $url = config('wodo.game-lobby-service-api') . '/lifecycle';
        return Http::retry(5, 1000)->post($url, [
            'id' => $gameLobby->id,
            'gameId' => $gameLobby->game_id,
            'name' => $gameLobby->name,
            'description' => $gameLobby->description,
            'gameMode' => $gameLobby->type->toGameLobbyServiceValue(),
            'rules' => $gameLobby->rules,
            'asset' => $gameLobby->asset->symbol,
            'entranceFee' => $gameLobby->base_entrance_fee,
            'startsAt' => $gameLobby->scheduled_at->utc(),
        ]);
    }
}
