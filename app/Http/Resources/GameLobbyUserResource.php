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
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'imageUrl' => $this->image_url,
            'username' => $this->username,
            'lastName' => $this->last_name,
            'fullName' => $this->full_name,
        ];
    }
}
