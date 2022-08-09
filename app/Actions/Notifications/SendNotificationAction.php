<?php

namespace App\Actions\Notifications;

use Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\NotificationType;
use App\Notifications\GameHubNotification;

class SendNotificationAction
{
    public function execute(User $user, $data): void
    {
        $notification = match ($data->type) {
            NotificationType::UserLeftLobby->value => new GameHubNotification($data),
            NotificationType::UserJoinedLobby->value => new GameHubNotification($data),
            default => null,
        };

        if (!$notification) {
            return;
        }

        $user->notify($notification);

        // Notification::send($user ,new GameHubNotification($message));
    }
}
