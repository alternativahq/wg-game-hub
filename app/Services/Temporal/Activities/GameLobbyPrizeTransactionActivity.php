<?php

namespace App\Services\Temporal\Activities;

use App\Enums\Wallet\TransactionAsset;
use App\Services\Temporal\Contracts\GameLobbyPrizeTransactionActivityContract;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GameLobbyPrizeTransactionActivity implements GameLobbyPrizeTransactionActivityContract
{
    public function sendTransaction(
        string $refId,
        string $toAccount,
        TransactionAsset $asset,
        float $amount,
        string $fromAccount,
    ): string {
        $url = config('wodo.wallet-transactions-api') . 'withdraw';
        $response = Http::post(
            url: $url,
            data: [
                'fromAccountId' => $fromAccount,
                'toAccountId' => $toAccount,
                'asset' => $asset->value,
                'amount' => $amount,
                'refId' => $refId,
            ],
        );

        if (!$response->ok()) {
            return $response->toException();
        }

        return $response->body();
    }
}
