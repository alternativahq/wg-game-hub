<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->whenNotNull($this->id),
            'name' => $this->whenNotNull($this->name),
            'email' => $this->whenNotNull($this->email),
            'image' => $this->whenNotNull($this->image),
            'image_url' => $this->whenNotNull($this->image_url),
            'username' => $this->whenNotNull($this->username),
            // 'email_verified_at' => $this->whenNotNull($this->email_verified_at),
            // 'password' => $this->whenNotNull($this->password),
            // 'remember_token' => $this->whenNotNull($this->remember_token),
            // 'created_at' => $this->whenNotNull($this->created_at),
            // 'updated_at' => $this->whenNotNull($this->updated_at),
            // 'deleted_at' => $this->whenNotNull($this->deleted_at),
            // 'two_factor_secret' => $this->whenNotNull($this->two_factor_secret),
            // 'two_factor_recovery_codes' => $this->whenNotNull($this->two_factor_recovery_codes),
            // 'two_factor_confirmed_at' => $this->whenNotNull($this->two_factor_confirmed_at),
            'last_name' => $this->whenNotNull($this->last_name),
            'full_name' => $this->whenNotNull($this->full_name),
            'assets' => AssetResource::collection($this->whenLoaded('assets')),
            'entrance_fee' => $this->whenPivotLoaded('game_lobby_user', function () {
                return $this->pivot->entrance_fee;
            }),
            'is_admin' => $this->when($request->user() && $request->user()->is_admin, true),
        ];
    }
}
