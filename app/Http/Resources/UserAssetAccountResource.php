<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\UserAssetAccount */
class UserAssetAccountResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'asset_id'   => $this->asset_id,
            'balance'    => $this->balance,
            'status'     => $this->status,
            'asset'      => new AssetResource($this->whenLoaded('asset')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
