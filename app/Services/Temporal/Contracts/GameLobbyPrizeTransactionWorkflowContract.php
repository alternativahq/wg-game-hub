<?php

namespace App\Services\Temporal\Contracts;

use App\Enums\Wallet\TransactionAsset;
use App\Models\GameLobby;
use Illuminate\Http\Client\Response;
use Temporal\Workflow\WorkflowInterface;
use Temporal\Workflow\WorkflowMethod;

#[WorkflowInterface]
interface GameLobbyPrizeTransactionWorkflowContract
{
    #[WorkflowMethod]
    public function handle(
        string $refId,
        string $toAccount,
        TransactionAsset $asset,
        float $amount,
        string $fromAccount,
    );
}
