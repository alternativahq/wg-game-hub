<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteWithdrawControllerRequest;

class CompleteWithdrawController extends Controller
{
    public function __invoke(CompleteWithdrawControllerRequest $request)
    {
        //TODO: forget the asset account cache to re get it from the end point
        auth()
            ->user()
            ->withdrawalConfirmations()
            ->delete();
        session()->flash('success', 'withdrawal confiremd!');
        return redirect()->route('user.withdraw');
    }
}
