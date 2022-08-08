<?php

namespace App\Actions\Notification;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\GameHubNotification;

class SendNotificationAction
{
    public function execute(User $user, $message): void
    {
        $user->notify(new GameHubNotification($message));
    }
}
