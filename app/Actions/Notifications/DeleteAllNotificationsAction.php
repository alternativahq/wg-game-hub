<?php

namespace App\Actions\Notification;

use App\Models\User;
use Illuminate\Http\Request;

class DeleteNotificationsAction
{
    public function execute(User $user): void
    {
        $user->notifications()->delete();
    }
}
