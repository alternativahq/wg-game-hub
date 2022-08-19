<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'globalTxId' => $this->globalTxId,
            'tenantId' => $this->tenantId,
            'refId' => $this->refId,
            'hash' => $this->hash,
            'type' => $this->type,
            'state' => $this->state,
            'asset' => $this->asset,
            'fromAccountId' => $this->fromAccountId,
            'toAccountId' => $this->toAccountId,
            'amount' => $this->amount,
            'fee' => $this->fee,
            'scope' => $this->scope,
            'createdAt' => $this->createdAt,
        ];
    }
}
