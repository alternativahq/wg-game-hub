<?php

namespace App\Actions\Notifications;

use Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\NotificationType;
use App\Notifications\GameHubNotification;

class SendNotificationAction
{
    public function execute(User $user, $message, $type): void
    {
        $user->notify(new GameHubNotification($message));

        match ($type) {
            NotificationType::UserLeftLobby     => $user->notify(new GameHubNotification($message)),
            NotificationType::UserJoinedLobby   => $user->notify(new GameHubNotification($message)),
            default => "their is no such notification",
        };

        // Notification::send($user ,new GameHubNotification($message));
    }
}
