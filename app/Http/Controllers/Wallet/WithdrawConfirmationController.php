<?php

namespace App\Http\Controllers\Wallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalConfirmation;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendWithdrawalConfirmationNotification;

class WithdrawConfirmationController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        $code = rand(100000,999999);
        WithdrawalConfirmation::create([
            'user_id' => $user->id,
            'code' => $code,
            'valid_for' => now()->addMinutes(5),
        ]);
        Notification::send($user, new SendWithdrawalConfirmationNotification($code));
    }
}
