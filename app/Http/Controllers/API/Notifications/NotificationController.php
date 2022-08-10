<?php

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationController extends Controller
{
    public function index(): ResourceCollection
    {
        $user = auth()->user();
        return NotificationResource::collection($user->notifications()->paginate());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unreadNotificationsCount()
    {
        $user = auth()->user();
        return $user->unreadNotifications()->count();
    }
}
