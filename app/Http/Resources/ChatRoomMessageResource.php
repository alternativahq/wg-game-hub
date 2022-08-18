<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ChatRoomMessage */
class ChatRoomMessageResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user_id' => $this->user_id,
            'chat_room_id' => $this->chat_room_id,
            'chat_room' => new ChatRoomResource($this->whenLoaded('chatRoom')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
