<?php

namespace App\Http\Controllers\Wallet;

use Auth;
use Cache;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalConfirmation;
use App\Http\Requests\CompleteWithdrawControllerRequest;

class CompleteWithdrawController extends Controller
{
    public function __invoke(CompleteWithdrawControllerRequest $request)
    {
        //TODO: forget the asset account cache to re get it from the end point
        $withdrawalConfirmations = WithdrawalConfirmation::where('id', $request->transaction_uuid)->where('code', $request->code)->first();
        //send the withdraw info to the api end point

        // Cache::forget('user.' . Auth::id() . '.account' . $request->network);
        // Cache::forget('user.' . Auth::id() . '.accounts');
        // auth()->user()->withdrawalConfirmations()->delete();
        session()->flash('success', 'withdrawal confiremd!');
        return redirect()->route('user.withdraw');
    }
}
