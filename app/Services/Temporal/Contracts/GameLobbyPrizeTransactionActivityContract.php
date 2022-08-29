<?php

namespace App\Services\Temporal\Contracts;
use App\Enums\Wallet\TransactionAsset;
use Illuminate\Http\Client\Response;
use Temporal\Activity\ActivityInterface;

#[ActivityInterface]
interface GameLobbyPrizeTransactionActivityContract
{
    public function sendTransaction(
        string $refId,
        string $toAccount,
        TransactionAsset $asset,
        float $amount,
        string $fromAccount,
    ): string;
}
