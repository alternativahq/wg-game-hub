<?php

namespace App\Http\Controllers\API\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Notification\SendNotificationAction;

class SendNotificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, SendNotificationAction $sendNotificationAction)
    {
        $sendNotificationAction->execute(auth()->user(), $request->message);
        return response()->noContent();
    }
}
