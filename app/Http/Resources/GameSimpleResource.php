<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/** @mixin \App\Models\Game */
class GameSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'image_url' => $this->image_url,
        ];
    }
}
