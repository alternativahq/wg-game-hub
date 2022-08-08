<?php

namespace App\Actions\Notification;

use Illuminate\Http\Request;

class GetUnreadNotificationCountAction
{
    public function execute()
    {
        $user = auth()->user();
        return count($user->unreadNotifications);
    }
}
