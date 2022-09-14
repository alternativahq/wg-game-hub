<?php

namespace App\Enums;
use Illuminate\Support\Collection;

enum GameLobbyStatus: int
{
    case Scheduled = 10;
    case InLobby = 20;
    case InGame = 30;
    case GameEnded = 40;
    case ProcessingResults = 50;
    case ResultsProcessed = 60;
    case DistributingPrizes = 70;
    case PrizesDistributed = 80;
    case Archived = 90;

    public function canProcessResult(): bool
    {
        return $this === GameLobbyStatus::GameEnded;
    }

    public function canJoinLobby(): bool
    {
        return in_array($this, [GameLobbyStatus::Scheduled, GameLobbyStatus::InLobby]);
    }

    public function canWatchLobby(): bool
    {
        return in_array($this, [
            GameLobbyStatus::InLobby,
            GameLobbyStatus::InGame,
            GameLobbyStatus::GameEnded,
            GameLobbyStatus::ProcessingResults,
        ]);
    }

    public static function toSelect(): Collection
    {
        return collect(GameLobbyStatus::cases())->map(function ($item) {
            return ['label' => $item->name, 'value' => $item->value];
        });
    }

    public function toLabel(): string
    {
        return __('gamehub.' . $this->name);
    }

    public function is(GameLobbyStatus $gameLobbyStatus): bool
    {
        return $this === $gameLobbyStatus;
    }
}
