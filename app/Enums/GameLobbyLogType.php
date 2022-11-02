<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum GameLobbyLogType: string
{
    case GameLobbyCreated = 'game-lobby-created';
    case GameLobbyStateScheduled = 'game-lobby-state-scheduled';
    case GameLobbyStateAwaitingPlayers = 'game-lobby-state-awaiting-players';
    case GameLobbyGameStartDelayed = 'game-lobby-game-start-delayed';
    case GameLobbyStateAbortedRefunding = 'game-lobby-game-aborted-refunding';
    case GameLobbyStateAborted = 'game-lobby-game-start-aborted';
    case GameLobbyStateEnded = 'game-lobby-state-ended';
    case UserJoined = 'user-joined';
    case UserLeft = 'user-left';
    case GameLobbyStateInGame = 'game-lobby-state-in-game';
    case GameLobbyDistributingPrizes = 'game-lobby-distributing-prizes';
    case GameLobbyDistributedPrizes = 'game-lobby-distributed-prizes';
    case GameLobbyArchived = 'game-lobby-archived';
    case GameLobbyStarTimeChanged = 'game-lobby-start-time-changed';
    case GameLobbyStartVotingPassed = 'game-lobby-start-voting-passed';
    case GameLobbyStartVotingFailed = 'game-lobby-start-voting-failed';
    case GameLobbyAborted = 'game-lobby-aborted';

    public static function toSelect(): Collection
    {
        return collect(GameLobbyAlgorithmsType::cases())->map(function ($item) {
            return [
                'label' => $item->name,
                'value' => $item->value,
            ];
        });
    }

    public function toLabel(): string
    {
        return __('game-lobby-activity-log.' . $this->value);
    }
}
