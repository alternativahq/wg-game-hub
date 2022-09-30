<?php

namespace App\Actions\Wallet;

use App\Models\Asset;
use App\Models\UserAssetAccount;
use App\Services\Internal\WalletAPI;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\WalletUserAssetAccountResource;

class GetUserAssetAccountsAction
{
    public function __construct(protected WalletAPI $walletAPI)
    {
    }

    public function execute(): AnonymousResourceCollection
    {
        $response = $this->walletAPI->accounts([
            'userId' => auth()->user()->id,
        ]);

        if ($response->failed()) {
            return WalletUserAssetAccountResource::collection([]);
        }

        $userAssetAccounts = collect($response->json('data', []))->map(function ($assetAccount) {
            return new UserAssetAccount($assetAccount);
        });

        //TODO: We may change it to pagination
        return WalletUserAssetAccountResource::collection($userAssetAccounts);
    }
}
