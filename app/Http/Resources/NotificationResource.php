<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'data'       => $this->data,
            'type'       => $this->type,
            'read_at'    => $this->read_at?$this->read_at->format('Y-m-d H:i:s'):null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
