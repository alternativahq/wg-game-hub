<?php

namespace App\Actions\Notifications;

use App\Models\User;
use Illuminate\Http\Request;

class MarkNotificationAsReadAction
{
    public function execute(Request $request, User $user, Notification $notification): void
    {
        $user->unreadNotifications->where('id', $notification->id)->markAsRead();
    }
}
