<?php

namespace App\Actions\Wallet;

use App\Models\Asset;
use App\Models\UserAssetAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\WalletUserAssetAccountResource;

class GetUserAssetAccountsAction
{
    public function execute()
    {
        $url = config('wodo.wallet-service') . 'accounts?userId=' . auth()->user()->id;
        $userAssetAccounts = Cache::remember(
            'user.' . auth()->user()->id . '.accounts',
            now()->addHours(2),
            function () use ($url) {
                $response = Http::get(url: $url);
                if ($response->failed()) {
                    return [];
                }
                return count($response->json('data')) ? $response->json('data') : [];
            },
        );

        $userAssetAccounts = collect($userAssetAccounts)->map(function ($val) {
            return new UserAssetAccount($val);
        });

        return WalletUserAssetAccountResource::collection($userAssetAccounts);
    }
}
