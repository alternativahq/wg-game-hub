<?php

namespace App\Actions\Notification;

use Illuminate\Http\Request;

class GetAllNotificationsAction
{
    public function execute()
    {
        $user = auth()->user();
        return $notification = $user->notifications()->get();
        // return $this->sendResponse(NotificationResource::collection($notification)->response()->getData(true),'notifications sent sussesfully');
    }
}
