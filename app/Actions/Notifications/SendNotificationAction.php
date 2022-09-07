<?php

namespace App\Actions\Notifications;

use App\Http\Requests\SendNotificationRequest;
use App\Models\User;
use App\Enums\NotificationType;
use App\Notifications\GameHubNotification;
use Illuminate\Support\Facades\Notification;

class SendNotificationAction
{
    public function execute(SendNotificationRequest $request, NotificationType $notificationType): void
    {
        $users = User::whereIn('id', $request->user_ids)->get(['id']);
        $notification = new $notificationType->value(json_decode($request->dataToObject(), true));

        Notification::send($users, $notification);
    }
}
