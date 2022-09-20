<?php

namespace App\Enums;
use Illuminate\Support\Collection;

enum GameLobbyAlgorithmsType: int
{
    case Linear = 1;
    case Winner = 2;
    case Top_20_Percent = 3;

    public static function toSelect(): Collection
    {
        return collect(GameLobbyAlgorithmsType::cases())->map(function ($item) {
            return ['label' => $item->name, 'value' => $item->value];
        });
    }
}
