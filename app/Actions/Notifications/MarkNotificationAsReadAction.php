<?php

namespace App\Actions\Notifications;

use App\Models\User;

class MarkNotificationAsReadAction
{
    public function execute(User $user, $notificationid): void
    {
        $user->unreadNotifications->where('id', $notificationid)->markAsRead();
    }
}
