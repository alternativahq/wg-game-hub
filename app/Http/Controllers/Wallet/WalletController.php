<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Auth;
use Inertia\Inertia;

class WalletController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $assetAccounts = $user
            ->assets()
            ->take(5)
            ->get(['user_asset_account.id', 'name', 'description', 'symbol']);

        return Inertia::render('Wallet/Wallet', [
            'assetAccounts' => $assetAccounts,
        ]);
    }
}
