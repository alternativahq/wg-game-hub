<?php

namespace App\Enums;
use Illuminate\Support\Collection;

enum GameLobbyType: int
{
    case TypeOne = 1;
    case TypeTwo = 2;
    
    public function toLabel(): string
    {
        return __('gamehub.' . $this->name);
    }
    
    public static function toSelect(): Collection
    {
        return collect(GameLobbyType::cases())->map(function($item){
            return ['label' => $item->name, 'value' => $item->value];
        });
    }
}
