<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Actions\Notifications\MarkNotificationAsReadAction;
use Illuminate\Notifications\DatabaseNotification;

class MarkNotificationAsReadController extends Controller
{
    public function __invoke(
        DatabaseNotification $notification,
        MarkNotificationAsReadAction $markNotificationAsReadAction,
    ):void {
        $markNotificationAsReadAction->execute(auth()->user(), $notification);
    }
}
