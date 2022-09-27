<?php

namespace App\Http\Controllers\Wallet;

use App\Actions\Wallet\GetUserAssetAccountsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserAssetAccountResource;
use Auth;
use Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct(protected GetUserAssetAccountsAction $userAssetAccountsAction)
    {
    }

    public function __invoke(Request $request)
    {
        $url = config('wodo.wallet-service') . 
        'accounts?userId=' . auth()->user()->id . 
        '&sort_by='.$request->sort_by . 
        '&sort_order=' . $request->sort_order;
        
        $response = \Illuminate\Support\Facades\Http::get(url: $url);
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
            'assetAccounts' => $assetAccounts,
            'filters' => $request->only('sort_by', 'sort_order'),
        ]);
    }
}
