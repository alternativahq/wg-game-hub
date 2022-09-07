<?php

namespace App\Actions\Wallet;

use App\Models\Asset;
use App\Models\UserAssetAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\WalletUserAssetAccountResource;

class GetUserAssetAccountAction
{
    public function execute(Asset $asset)
    { 
        $url = config('wodo.wallet-service') . 'accounts?userId='. auth()->user()->id .'&asset='.$asset->symbol;
        Cache::forget('user.' . auth()->user()->id . '.account' . $asset->symbol);

        $userAssetAccounts = Cache::remember('user.' . auth()->user()->id . '.account' . $asset->symbol , now()->addHours(2), function () use($url) {
            $response = Http::get(url: $url);
            if ($response->failed()) {
                return [];
            }
            return count($response->json('data')) ? $response->json('data') : [];
        });
        
        return new WalletUserAssetAccountResource(new UserAssetAccount($userAssetAccounts[0]));
    }
}
