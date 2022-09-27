<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class GameLobbyUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'userId' => $this->id,
            'username' => $this->username,
        ];
    }
}
