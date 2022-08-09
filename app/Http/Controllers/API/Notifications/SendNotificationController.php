<?php

namespace App\Http\Controllers\API\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendNotificationRequest;
use App\Actions\Notifications\SendNotificationAction;

class SendNotificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SendNotificationRequest $request, SendNotificationAction $sendNotificationAction)
    {
         $user = User::first();
        return $sendNotificationAction->execute($user, $request->message);
        return response()->noContent();
    }
}
