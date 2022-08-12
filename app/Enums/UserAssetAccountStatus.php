<?php

namespace App\Enums;

use JsonSerializable;

enum UserAssetAccountStatus: int
{
    case Active = 1;
    case Inactive = 2;

    public function toLabel(): string
    {
        return __('gamehub.' . $this->name);
    }
}
