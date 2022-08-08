<?php

namespace App\Actions\Notification;

use Illuminate\Http\Request;

class MarkNotificationAsReadAction
{
    public function execute(Request $request): void
    {
        $user = auth()->user();
        $user->unreadNotifications->when($request->id,function($quary) use ($request){
            return $quary->where('id', $request->id);
        })->markAsRead();
    }
}
