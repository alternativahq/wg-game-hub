<?php

namespace App\Actions\Notifications;

use App\Models\User;

class DeleteAllNotificationsAction
{
    public function execute(User $user): void
    {
        $user->notifications()->delete();
    }
}
