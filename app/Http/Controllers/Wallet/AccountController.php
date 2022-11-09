<?php

namespace App\Http\Controllers\Wallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Internal\WalletAPI;
use App\Http\Requests\StoreAccountRequest;

class AccountController extends Controller
{
    public function __construct(protected WalletAPI $walletAPI)
    {
    }

    public function store(StoreAccountRequest $request)
    {
        $response = $this->walletAPI->creatAccount(['userId' => auth()->user()->id, 'asset' => $request->coin]);

        if (!$response->ok()) {
            session()->flash('error', 'Something went wrong, please try again later');
            return redirect()->back();
        }

        session()->flash('success', 'Account genrated successfully!');
        return redirect('/wallet/deposit?coin=XWGT');
    }
}
