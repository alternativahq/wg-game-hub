<?php

namespace App\Actions\Notification;

use Illuminate\Http\Request;
use App\Notifications\GameHubNotification;

class SendNotificationAction
{
    public function execute($message): void
    {
        $user = auth()->user();
        $user->notify(new GameHubNotification($message));
    }
}
