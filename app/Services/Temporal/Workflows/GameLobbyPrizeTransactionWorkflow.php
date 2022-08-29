<?php

namespace App\Services\Temporal\Workflows;

use App\Enums\Wallet\TransactionAsset;
use App\Services\Temporal\Contracts\GameLobbyPrizeTransactionActivityContract;
use App\Services\Temporal\Contracts\GameLobbyPrizeTransactionWorkflowContract;
use Carbon\CarbonInterval;
use Temporal\Activity\ActivityOptions;
use Temporal\Workflow;

class GameLobbyPrizeTransactionWorkflow implements GameLobbyPrizeTransactionWorkflowContract
{
    private $gameLobbyPrizeTransactionWorkflow;

    public function __construct()
    {
        $this->gameLobbyPrizeTransactionWorkflow = Workflow::newActivityStub(
            GameLobbyPrizeTransactionActivityContract::class,
            ActivityOptions::new()->withStartToCloseTimeout(CarbonInterval::seconds(2)),
        );
    }

    public function handle(
        string $refId,
        string $toAccount,
        TransactionAsset $asset,
        float $amount,
        string $fromAccount,
    ) {
        return $this->gameLobbyPrizeTransactionWorkflow->sendTransaction(
            refId: $refId,
            toAccount: $toAccount,
            asset: $asset,
            amount: $amount,
            fromAccount: $fromAccount,
        );
    }
}
