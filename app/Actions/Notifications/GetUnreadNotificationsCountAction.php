<?php

namespace App\Actions\Notification;

use Illuminate\Http\Request;

<<<<<<< Updated upstream
class GetUnreadNotificationCountAction
=======
class GetUnreadNotificationsCountAction
>>>>>>> Stashed changes
{
    public function execute()
    {
        $user = auth()->user();
        return count($user->unreadNotifications);
    }
}
