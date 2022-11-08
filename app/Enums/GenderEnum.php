<?php

namespace App\Enums;
use Illuminate\Support\Collection;

enum GenderEnum: string
{
    case m = "m";
    case f = "f";
    case o = "o";

    public static function toSelect(): Collection
    {
        return collect(GenderEnum::cases())->map(function ($item) {
            return ['label' => $item->name, 'value' => $item->value];
        });
    }
}
