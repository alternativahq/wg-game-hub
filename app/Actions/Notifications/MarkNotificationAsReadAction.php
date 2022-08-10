<?php

namespace App\Actions\Notifications;

use App\Models\User;

class MarkNotificationAsReadAction
{
    public function execute(User $user, $notificationId): void
    {
        $user
            ->unreadNotifications()
            ->where('id', $notificationId)
            ->update([
                'read_at' => now(),
            ]);
    }
}
