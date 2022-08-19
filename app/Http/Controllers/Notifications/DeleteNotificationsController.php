<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Actions\Notifications\DeleteAllNotificationsAction;

class DeleteNotificationsController extends Controller
{
    public function __invoke(DeleteAllNotificationsAction $deleteAllNotificationsAction):void
    {
        $deleteAllNotificationsAction->execute(auth()->user());
    }
}
