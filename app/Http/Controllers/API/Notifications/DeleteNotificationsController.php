<?php

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\Controller;
use App\Actions\Notifications\DeleteAllNotificationsAction;

class DeleteNotificationsController extends Controller
{
    public function __invoke(DeleteAllNotificationsAction $deleteAllNotificationsAction)
    {
        $deleteAllNotificationsAction->execute(auth()->user());
        return response()->noContent();
    }
}
