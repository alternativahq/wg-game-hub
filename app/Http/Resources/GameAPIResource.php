<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Game */
class GameAPIResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'imageUrl' => $this->image_url,
            'status' => $this->whenNotNull($this->status),
            'achievements_count' => $this->whenCounted('achievements'),
            //            'game_lobbies_count' => $this->whenCounted('gameLobbies'),
            'created_at' => $this->whenNotNull($this->created_at),
            'updated_at' => $this->whenNotNull($this->updated_at),

            'achievements' => AchievementResource::collection($this->whenLoaded('achievements')),
            'game_lobbies' => GameLobbyResource::collection($this->whenLoaded('gameLobbies')),
            'game_lobbies_count' => $this->whenCounted('gameLobbies'),
        ];
    }
}
