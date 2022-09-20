<?php

namespace App\Actions\GameLobby;

use App\Enums\GameLobbyStatus;
use App\Enums\GameLobbyType;
use App\Http\Requests\StoreLobbyRequest;
use App\Models\Asset;
use App\Models\GameLobby;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Str;

class GameLobbyStartSignalAction
{
    public function execute(
        StoreLobbyRequest $request,
    ): \Illuminate\Http\Client\Response|\GuzzleHttp\Promise\PromiseInterface {

        $asset = Asset::find($request->asset_id);

        $payload = [
            'id' => Str::uuid()->toString(),
            'gameId' => $request->gameId,
            'name' => $request->name,
            'description' => $request->description,
            'themeColor' => $request->theme_color,
            'gameMode' => GameLobbyType::tryFrom($request->type)->toGameLobbyServiceValue(),
            'rules' => $request->rules,
            'asset' => $asset->symbol,
            'state' => GameLobbyStatus::Scheduled->toGameLobbyServiceValue(),
            'baseEntranceFee' => $request->base_entrance_fee,
            'scheduledAt' => $request->scheduled_at,
            'startsAt' => $request->start_at,
            'minPlayers' => $request->min_players,
            'maxPlayers' => $request->max_players,
            'scheduleWaitTime' => Carbon::now()
                ->utc()
                ->diffInSeconds($request->scheduled_at),
            'waitTime' => Carbon::now()
                ->utc()
                ->diffInSeconds($request->start_at),
            'algorithmId' => $request->algorithm_id,
        ];

        $url = config('wodo.game-lobby-service-api') . '/lifecycle';
        return Http::retry(5, 1000)->post($url, $payload);
    }
}
