<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Asset */
class UserAssetAccountPageResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'symbol' => $this->symbol,
            'balance' => $this->whenPivotLoaded('user_asset_account', function () {
                return $this->pivot->balance;
            }),
        ];
    }
}
