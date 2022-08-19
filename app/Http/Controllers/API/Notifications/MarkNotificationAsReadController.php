<?php

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\Controller;
use App\Actions\Notifications\MarkNotificationAsReadAction;
use Illuminate\Notifications\DatabaseNotification;

class MarkNotificationAsReadController extends Controller
{
    public function __invoke(
        DatabaseNotification $notification,
        MarkNotificationAsReadAction $markNotificationAsReadAction,
    ) {
        $markNotificationAsReadAction->execute(auth()->user(), $notification);
        return response()->noContent();
    }
}
