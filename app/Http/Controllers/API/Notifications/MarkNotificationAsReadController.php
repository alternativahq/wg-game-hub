<?php

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\Controller;
use App\Actions\Notifications\MarkNotificationAsReadAction;
use Notification;

class MarkNotificationAsReadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Notification $notification, MarkNotificationAsReadAction $markNotificationAsReadAction)
    {
        $markNotificationAsReadAction->execute(auth()->user(), $notification);
        return response()->noContent();
    }
}
