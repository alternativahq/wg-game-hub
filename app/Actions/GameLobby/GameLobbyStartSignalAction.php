<?php

namespace App\Actions\GameLobby;

use App\Enums\GameLobbyStatus;
use App\Enums\GameLobbyType;
use App\Http\Requests\StoreLobbyRequest;
use App\Models\Asset;
use App\Models\GameLobby;
use App\Services\Internal\GameLobbyServiceAPI;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Str;

class GameLobbyStartSignalAction
{
    public function __construct(protected GameLobbyServiceAPI $gameLobbyServiceAPI)
    {
    }

    public function execute(
        StoreLobbyRequest $request,
    ): \Illuminate\Http\Client\Response|\GuzzleHttp\Promise\PromiseInterface {
        $asset = Asset::find($request->asset_id);

        $payload = [
            'id' => Str::uuid()->toString(),
            'gameId' => $request->game_id,
            'name' => $request->name,
            'description' => $request->description,
            'themeColor' => $request->theme_color,
            'gameMode' => GameLobbyType::tryFrom($request->type)->toGameLobbyServiceValue(),
            'rules' => $request->rules,
            'asset' => $asset->symbol,
            'state' => GameLobbyStatus::Scheduled->toGameLobbyServiceValue(),
            'baseEntranceFee' => $request->base_entrance_fee * 1,
            'commission' => $request->commission * 1,
            'scheduledAt' => $request->scheduled_at,
            'startsAt' => $request->start_at,
            'minPlayers' => $request->min_players * 1,
            'maxPlayers' => $request->max_players * 1,
            'gamePlayDuration' => $request->game_play_duration * 60,
            'scheduleWaitTime' => Carbon::now()
                ->utc()
                ->diffInSeconds($request->scheduled_at),
            'waitTime' => Carbon::now()
                ->utc()
                ->diffInSeconds($request->start_at),
            'algorithmId' => $request->algorithm_id,
            'gameStartDelayTime' => $request->game_start_delay_time * 60,
            'gameStartDelayLimit' => $request->game_start_delay_limit * 1
        ];

        return $this->gameLobbyServiceAPI->startLifecycle($payload);
    }
}
