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
            'status' => $this->whenNotNull($this->status->toLabel()),
            'achievements_count' => $this->whenCounted('achievements'),
            //'game_lobbies_count' => $this->whenCounted('gameLobbies'),
            'createdAt  ' => $this->whenNotNull($this->created_at),
            'updatedAt  ' => $this->whenNotNull($this->updated_at),
            'deletedAt  ' => $this->deleted_at,

            'achievements' => AchievementResource::collection($this->whenLoaded('achievements')),
            'game_lobbies' => GameLobbyResource::collection($this->whenLoaded('gameLobbies')),
            'game_lobbies_count' => $this->whenCounted('gameLobbies'),
        ];
    }
}
