<?php

namespace App\Http\Controllers\API\Notifications;

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
        $sendNotificationAction->execute(auth()->user(), $request->data);
        return response()->noContent();
    }
}
