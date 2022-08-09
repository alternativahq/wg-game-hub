<?php

namespace App\Http\Controllers\API\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Notifications\DeleteAllNotificationsAction;

class DeleteNotificationsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, DeleteAllNotificationsAction $deleteAllNotificationsAction)
    {
        $deleteAllNotificationsAction->execute(auth()->user());
        return response()->noContent();
    }
}
