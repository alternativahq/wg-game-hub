<?php

namespace App\Enums;
use Illuminate\Support\Collection;

enum GameLobbyStatus: int
{
    case Scheduled = 10;
    case AwaitingPlayers = 20;
    case InGame = 30;
    case GameEnded = 40;
    case DistributingPrizes = 50;
    case DistributedPrizes = 60;
    case Archived = 70;

    public function canProcessResult(): bool
    {
        return $this === GameLobbyStatus::GameEnded;
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

    public function not(GameLobbyStatus $gameLobbyStatus): bool
    {
        return $this !== $gameLobbyStatus;
    }
}
