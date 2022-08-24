<?php

namespace App\Enums;

enum GameStatus: int
{
    case Beta = 1;
    case Online = 2;

    public function toLabel(): string
    {
        return __('gamehub.' . $this->name);
    }
}
