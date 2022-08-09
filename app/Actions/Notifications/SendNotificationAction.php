<?php

namespace App\Actions\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\GameHubNotification;
use Notification;

class SendNotificationAction
{
    public function execute(User $user, $message)
    {
        // return $user;
        // Notification::send($user ,new GameHubNotification($message));
        // $user->notify(new GameHubNotification($message));
    }
}
