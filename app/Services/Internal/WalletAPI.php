<?php

namespace App\Services\Internal;

use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class WalletAPI
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('wodo.wallet-service-base-url');
    }

    public function accounts(array $query = []): Response
    {
        $url = $this->baseUrl . '/accounts';

        return Http::get($url, $query);
    }

    public function depositToHomeAccount(array $data): Response
    {
        $url = $this->baseUrl . '/txs/home-deposit';
        return Http::post($url, $data);
    }

    public function withdrawFromHomeAccount(array $data): Response
    {
        $url = $this->baseUrl . '/txs/home-withdraw';
        return Http::post($url, $data);
    }

    public function listTransactions(array $data): Response
    {
        $url = $this->baseUrl . '/txs';

        return Http::get($url, $data);
    }

    public function transactionLog(string $transactionId): Response
    {
        $url = $this->baseUrl . '/txs/logs';
        return Http::get($url, ['txId' => $transactionId]);
    }
}
