<?php

namespace App\Actions\Notifications;

use App\Http\Requests\SendNotificationRequest;
use App\Models\User;
use App\Enums\NotificationType;
use App\Notifications\GameHubNotification;
use Illuminate\Support\Facades\Notification;

class SendNotificationAction
{
    public function execute(SendNotificationRequest $request): void
    {
        $notification = match ($request->type) {
            NotificationType::UserLeftLobby->value => GameHubNotification::class,
            NotificationType::UserJoinedLobby->value => GameHubNotification::class,
            default => null,
        };

        if (!$notification) {
            return;
        }

        $users = User::whereIn('id', $request->user_ids)->get(['id']);
        new $notification($request->dataToObject());
        Notification::send($users, new $notification($request->dataToObject()));
    }
}
