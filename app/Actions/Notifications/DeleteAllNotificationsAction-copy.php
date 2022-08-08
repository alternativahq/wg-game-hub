<?php

namespace App\Actions\Notification;

use Illuminate\Http\Request;

class DeleteNotificationsAction
{
    public function execute(): void
    {
        $user =auth()->user();
        if(count($notification =$user->notifications)>1){
            $user->notifications()->delete();
        }
    }
}
