<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminGameLobbyTemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->whenNotNull($this->name),
            'image' => $this->whenNotNull($this->image),
            'theme_color' => $this->whenNotNull($this->theme_color),
            'rules' => $this->whenNotNull($this->rules),
            'base_entrance_fee' => $this->whenNotNull($this->base_entrance_fee),
            'created_at' => $this->whenNotNull($this->created_at),
            'updated_at' => $this->whenNotNull($this->updated_at),
            'description' => $this->whenNotNull($this->description),
            'max_players' => $this->whenNotNull($this->max_players),
            'min_players' => $this->whenNotNull($this->min_players),
            'game_id' => $this->whenNotNull($this->game_id),
            'asset_id' => $this->whenNotNull($this->asset_id),
            'asset' => new AssetResource($this->whenLoaded('asset')),
            'game' => new GameResource($this->whenLoaded('game')),
        ];
    }
}
