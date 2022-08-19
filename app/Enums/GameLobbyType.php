<?php

namespace App\Enums;

enum GameLobbyType: int
{
    case TypeOne = 1;
    case TypeTwo = 2;
    
    public function toLabel(): string
    {
        return __('gamehub.' . $this->name);
    }
}
