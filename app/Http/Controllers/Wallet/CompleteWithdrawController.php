<?php

namespace App\Http\Controllers\Wallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalConfirmation;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\CompleteWithdrawControllerRequest;
use App\Notifications\SendWithdrawalConfirmationNotification;

class CompleteWithdrawController extends Controller
{
    public function __invoke(CompleteWithdrawControllerRequest $request)
    {
        return $request->code;
        return auth()->user()->withdrawalConfirmations;
    }
}
