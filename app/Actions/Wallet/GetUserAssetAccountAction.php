<?php

namespace App\Actions\Wallet;

use App\Models\Asset;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\WalletUserAssetAccountResource;

class GetUserAssetAccountAction
{
    public function execute(Asset $asset)
    { 
        $url = config('wodo.wallet-service') . 'accounts?userId='. auth()->user()->id .'&asset='.$asset->symbol;

        $userAssetAccounts = Cache::remember('user.' . auth()->user()->id . '.account' . $asset->symbol , now()->addHours(2), function () use($url) {
            $response = Http::get(url: $url);
            if ($response->failed()) {
                return [];
            }
            return $response->object()->data;
        });
        return new WalletUserAssetAccountResource($userAssetAccounts[0]);
    }
}
