<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\GameLobbyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GameLobbyActivityLogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->whenNotNull($this->name),
            'description' => $this->whenNotNull($this->description),
            'payload' => $this->whenNotNull($this->payload),
            'date' => $this->whenNotNull($this->created_at),
            'gameLobby' => new GameLobbyResource($this->whenLoaded('gameLobby')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
