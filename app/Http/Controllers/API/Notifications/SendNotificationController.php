<?php

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendNotificationRequest;
use App\Actions\Notifications\SendNotificationAction;

class SendNotificationController extends Controller
{
    public function __invoke(SendNotificationRequest $request, SendNotificationAction $sendNotificationAction)
    {
        $sendNotificationAction->execute(request: $request);
        return response()->noContent();
    }
}
