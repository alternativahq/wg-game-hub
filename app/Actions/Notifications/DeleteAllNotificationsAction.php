<?php

namespace App\Actions\Notifications;

use App\Models\User;
use Illuminate\Http\Request;

class DeleteAllNotificationsAction
{
    public function execute(User $user): void
    {
        $user->notifications()->delete();
    }
}
