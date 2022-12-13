<?php

namespace App\Http\Controllers\Wallet;

use Auth;
use Http;
use Inertia\Inertia;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Internal\WalletAPI;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\UserAssetAccountResource;
use App\Actions\Wallet\GetUserAssetAccountsAction;

class WalletController extends Controller
{
    public function __construct(
        protected GetUserAssetAccountsAction $userAssetAccountsAction,
        protected WalletAPI $walletAPI,
    ) {
    }

    public function __invoke(Request $request)
    {
        $assets = Asset::get(['id', 'name', 'symbol']);
        $response = $this->walletAPI->accounts(
            query: [
                'userId' => auth()->user()->id,
                'sort_by' => $request->sort_by,
                'sort_order' => $request->sort_order,
                'asset' => $request->filter_by_asset,
                'balance' => $request->balance_from,
                'balance' => $request->balance_to,
            ],
        );

        if ($response->failed()) {
            session()->flash('error', 'Something went wrong, please try again later');
            return redirect()->back();
        }
        $assetAccounts = new LengthAwarePaginator(
            $response->object()->data,
            $response->object()->meta->total,
            $response->object()->meta->per_page,
            $response->object()->meta->current_page,
            [
                'path' => url()->current(),
            ],
        );

        return Inertia::render('Wallet/Wallet', [
            'assets' => $assets,
            'assetAccounts' => $assetAccounts,
            'filters' => $request->only('sort_by', 'sort_order', 'filter_by_asset', 'balance_from', 'balance_to'),
        ]);
    }
}
