<?php

namespace App\Actions\Wallet;

use App\Models\Asset;
use App\Models\UserAssetAccount;
use App\Services\Internal\WalletAPI;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\WalletUserAssetAccountResource;

class GetUserAssetAccountAction
{
    public function __construct(protected WalletAPI $walletAPI)
    {
    }

    public function execute(Asset $asset): JsonResource
    {
        $response = $this->walletAPI->accounts([
            'userId' => auth()->user()->id,
            'asset' => $asset->symbol,
        ]);

        if ($response->failed()) {
            // TODO: Change this according to wodo docs
            return new WalletUserAssetAccountResource(new UserAssetAccount([]));
        }

        if (count($response->json('data', [])) === 0) {
            return new WalletUserAssetAccountResource(new UserAssetAccount([]));
        }

        $account = new UserAssetAccount($response->json('data')[0]);
        return new WalletUserAssetAccountResource($account);
    }
}
