<?php

namespace App\Http\Controllers\API\Notifications;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::first();
        return NotificationResource::collection($user->notifications()->paginate());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unreadNotificationsCount()
    {
        $user = User::first();
        return $user->unreadNotifications()->count();
    }
}
