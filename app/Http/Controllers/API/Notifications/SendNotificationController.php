<?php

namespace App\Http\Controllers\API\Notifications;

use App\Enums\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendNotificationRequest;
use App\Actions\Notifications\SendNotificationAction;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class SendNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.basic-auth');
    }

    public function __invoke(SendNotificationRequest $request, SendNotificationAction $sendNotificationAction)
    {
        abort_if(
            is_null($notificationType = NotificationType::tryFromKey($request->type)),
            Response::HTTP_UNAUTHORIZED,
            'Notification type is not identified',
        );

        $sendNotificationAction->execute(request: $request, notificationType: $notificationType);
        return response()->noContent();
    }
}
