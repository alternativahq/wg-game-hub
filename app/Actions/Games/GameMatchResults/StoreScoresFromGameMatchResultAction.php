<?php

namespace App\Actions\Games\GameMatchResults;

use App\DataTransferObjects\GameMatchResultData;
use App\Models\GameLobby;
use App\Models\GameLobbyUserScore;
use Str;

class StoreScoresFromGameMatchResultAction
{
    public function execute(GameLobby $gameLobby, GameMatchResultData $gameMatchResultData): void
    {
        $gameMatchScoreModels = collect($gameMatchResultData->scores)->map(
            fn($playerScore) => new GameLobbyUserScore(
                $this->attributes(gameLobby: $gameLobby, playerScore: $playerScore),
            ),
        );

        $gameLobby->scores()->saveMany($gameMatchScoreModels);
    }

    protected function attributes(GameLobby $gameLobby, array $playerScore): array
    {
        $playerScore = collect($playerScore)
            ->only('userId', 'rank', 'score', 'timePlayed')
            ->keyBy(function ($value, $key) {
                return Str::snake($key);
            })
            ->toArray();
        return array_merge($playerScore, [
            'game_id' => $gameLobby->game_id,
        ]);
    }
}
