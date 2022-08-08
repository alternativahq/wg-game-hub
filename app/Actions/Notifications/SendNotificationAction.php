<?php

namespace App\Actions\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\GameHubNotification;

class SendNotificationAction
{
    public function execute(User $user, $message)
    {
        return $message;
        $user->notify(new GameHubNotification($message));
    }
}
