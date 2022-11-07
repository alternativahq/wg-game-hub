<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\GameAPIResource;
use App\Http\Resources\UserResourceAPI;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GameLobbyActivityLogResource;

class GameLobbyAPIResource extends JsonResource
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
            'imageUrl' => $this->whenNotNull($this->image_url),
            'themeColor' => $this->whenNotNull($this->theme_color),
            'type' => $this->whenNotNull($this->type),
            'typeLabel' => $this->type ? $this->type->toLabel() : '',
            'state' => $this->whenNotNull($this->state),
            'rules' => $this->whenNotNull($this->rules),
            'baseEntranceFee' => $this->whenNotNull($this->base_entrance_fee),
            'description' => $this->whenNotNull($this->description),
            'maxPlayers' => $this->whenNotNull($this->max_players),
            'minPlayers' => $this->whenNotNull($this->min_players),
            'gamePlayDuration' => $this->whenNotNull($this->game_play_duration),
            'latestUpdate' => $this->whenNotNull($this->latest_update),
            'availableSpots' => $this->whenNotNull($this->available_spots),
            'hasAvailableSpots' => $this->whenNotNull($this->has_available_spots),
            'playersInLobbyCount' => $this->whenNotNull($this->players_in_lobby_count),
            'scheduledAtUtcString' => $this->whenNotNull($this->scheduled_at_utc_string),
            'prizePool' => $this->whenNotNull($this->prize_pool),
            'startAtUtcString' => $this->whenNotNull($this->start_at_utc_string),
            'scheduledAt' => $this->whenNotNull($this->scheduled_at),
            'startAt' => $this->whenNotNull($this->start_at),
            'algorithmId' => $this->whenNotNull($this->algorithm_id),
            'gameStartDelayTime' => $this->whenNotNull($this->game_start_delay_time),
            'gameStartDelayLimit' => $this->whenNotNull($this->game_start_delay_limit),
            'scheduledAtDateTime' => $this->whenNotNull($this->scheduled_at_to_date_time),
            'usersCount' => $this->whenNotNull($this->users_count),
            'gameId' => $this->whenNotNull($this->game_id),
            'assetId' => $this->whenNotNull($this->asset_id),
            'createdAt' => $this->whenNotNull($this->created_at),
            'updatedAt' => $this->whenNotNull($this->updated_at),
            'gameLobbyLogs' => GameLobbyActivityLogResource::collection($this->whenLoaded('activityLogs')),
            'asset' => new AssetResource($this->whenLoaded('asset')),
            'game' => new GameAPIResource($this->whenLoaded('game')),
            'users' => UserResourceAPI::collection($this->whenLoaded('users')),
            'scores' => UserScoreResource::collection($this->whenLoaded('scores')),
            'url' => $this->url,
        ];
    }
}
