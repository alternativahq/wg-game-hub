<?php

namespace App\Http\Controllers\Wallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalConfirmation;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\WithdrawConfirmationControllerRequest;
use App\Notifications\SendWithdrawalConfirmationNotification;

class WithdrawConfirmationController extends Controller
{
    public function __invoke(WithdrawConfirmationControllerRequest $request)
    {
        $user = auth()->user();
        $code = rand(100000, 999999);
        $WithdrawalConfirmation = WithdrawalConfirmation::create([
            'user_id' => $user->id,
            'code' => $code,
            'valid_until' => now()->addMinutes(5),
            'coin' => $request->coin,
            'amount' => $request->amount,
            'wallet_address' => $request->wallet_address,
            'network' => $request->network,
        ]);
        //Notification::send($user, new SendWithdrawalConfirmationNotification($code));

        return redirect()->route('user.withdraw', ['withdrawTransactionsUuid' => $WithdrawalConfirmation->id, 'coin' => $request->coin]);
    }
}
