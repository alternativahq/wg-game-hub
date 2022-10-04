<?php

namespace App\Enums;
use Illuminate\Support\Collection;

enum GameLobbyLogsType: String
{
    case GameLobbyCreated = 'game-lobby-created';
    case GameLobbyStateScheduled = 'game-lobby-state-scheduled';
    case GameLobbyStateAwaitingPlayers = 'game-lobby-state-awaiting-players';
    case Userjoined = 'user-joined';
    case Userleft = 'user-left';
    case UserRejoined = 'user-rejoined';
    case GameLobbyStateInGame = 'game-lobby-state-in-game';
    case GameLobbyDistributingPrizes = 'game-lobby-distributed-prizes';
    case GameLobbyArchived = 'game-lobby-archived';
    case GameLobbyStartimeChanged = 'game-lobby-start-time-changed';
    case GameLobbyStartVotingPassed = 'game-lobby-start-voting-passed';
    case GameLobbyStartVotingFailed = 'game-lobby-start-voting-failed';
    case GameLobbyAborted = 'game-lobby-aborted';

    public static function toSelect(): Collection
    {
        return collect(GameLobbyAlgorithmsType::cases())->map(function ($item) {
            return ['label' => $item->name, 'value' => $item->value];
        });
    }
}
