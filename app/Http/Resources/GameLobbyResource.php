<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\GameLobby */
class GameLobbyResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->whenNotNull($this->name),
            'image' => $this->whenNotNull($this->image),
            'image_url' => $this->whenNotNull($this->image_url),
            'theme_color' => $this->whenNotNull($this->theme_color),
            'type' => $this->whenNotNull($this->type),
            'status' => $this->whenNotNull($this->status),
            'rules' => $this->whenNotNull($this->rules),
            'base_entrance_fee' => $this->whenNotNull($this->base_entrance_fee),
            'created_at' => $this->whenNotNull($this->created_at),
            'updated_at' => $this->whenNotNull($this->updated_at),
            'description' => $this->whenNotNull($this->description),
            'max_players' => $this->whenNotNull($this->max_players),
            'min_players' => $this->whenNotNull($this->min_players),
            'available_spots' => $this->whenNotNull($this->available_spots),
            'has_available_spots' => $this->whenNotNull($this->has_available_spots),
            'players_in_lobby_count' => $this->whenNotNull($this->players_in_lobby_count),
            'scheduled_at_utc_string' => $this->whenNotNull($this->scheduled_at_utc_string),
            'scheduled_at' => $this->whenNotNull($this->scheduled_at),
            'scheduled_at_date_time' => $this->whenNotNull($this->scheduled_at_to_date_time),
            'users_count' => $this->whenNotNull($this->users_count),
            'game_id' => $this->whenNotNull($this->game_id),
            'asset_id' => $this->whenNotNull($this->asset_id),
            'asset' => new AssetResource($this->whenLoaded('asset')),
            'game' => new GameResource($this->whenLoaded('game')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'scores' => UserScoreResource::collection($this->whenLoaded('scores')),
        ];
    }
}
