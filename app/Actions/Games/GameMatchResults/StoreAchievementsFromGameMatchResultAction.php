<?php

namespace App\Actions\Games\GameMatchResults;

use App\DataTransferObjects\GameMatchResultData;
use App\Models\GameLobby;
use App\Models\UserAchievement;
use Str;

class StoreAchievementsFromGameMatchResultAction
{
    public function execute(GameLobby $gameLobby, GameMatchResultData $gameMatchResultData): void
    {
        $gameMatchAchievementsModels = collect($gameMatchResultData->achievements)->map(
            fn($playerAchievement) => new UserAchievement(
                $this->attributes(gameLobby: $gameLobby, playerAchievements: $playerAchievement),
            ),
        );

        $gameLobby->usersAchievements()->saveMany($gameMatchAchievementsModels);
    }

    protected function attributes(GameLobby $gameLobby, array $playerAchievements): array
    {
        $playerAchievements = collect($playerAchievements)
            ->only('userId', 'achievementId', 'additionalInfo')
            ->keyBy(function ($value, $key) {
                return Str::snake($key);
            })
            ->toArray();

        return array_merge($playerAchievements, [
            'game_id' => $gameLobby->game_id,
            'game_lobby_id' => $gameLobby->id,
        ]);
    }
}
