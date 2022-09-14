<?php

namespace App\Enums;
use Illuminate\Support\Collection;
use Str;

enum GameLobbyType: int
{
    case DeathMatch = 1;
    case LastManStanding = 2;
    case OneVOne = 3;
    case TeamVTeam = 4;

    public function toLabel(): string
    {
        return __('gamehub.' . $this->name);
    }

    public static function toSelect(): Collection
    {
        return collect(GameLobbyType::cases())->map(function ($item) {
            return ['label' => $item->name, 'value' => $item->value];
        });
    }

    public function toGameLobbyServiceValue(): string
    {
        return str($this->name)
            ->snake()
            ->upper()
            ->value();
    }
}
