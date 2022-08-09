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
        $user->notify(new GameHubNotification($data));

        match ($data->type) {
            NotificationType::UserLeftLobby     => $user->notify(new GameHubNotification($data)),
            NotificationType::UserJoinedLobby   => $user->notify(new GameHubNotification($data)),
        };

        // Notification::send($user ,new GameHubNotification($message));
    }
}
