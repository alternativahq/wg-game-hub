<?php

namespace App\Actions\Notifications;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class MarkNotificationAsReadAction
{
    public function execute(User $user, DatabaseNotification $notification): void
    {
        $user
            ->unreadNotifications()
            ->where('id', $notification->id)
            ->update([
                'read_at' => now(),
            ]);
    }
}
