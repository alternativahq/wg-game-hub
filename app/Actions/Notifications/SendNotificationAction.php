<?php

namespace App\Actions\Notifications;

use App\Http\Requests\SendNotificationRequest;
use App\Models\BlacklistedNotification;
use App\Models\User;
use App\Enums\NotificationType;
use App\Notifications\GameHubNotification;
use Cache;
use Illuminate\Support\Facades\Notification;

class SendNotificationAction
{
    public function execute(SendNotificationRequest $request, NotificationType $notificationType): void
    {
        $alreadySentNotification = Cache::remember(
            'notifications:idempotency_id:' . $request->idempotency_id,
            now()->addMinutes(3),
            function () use ($request) {
                return BlacklistedNotification::find($request->idempotency_id);
            },
        );

        if ($alreadySentNotification) {
            return;
        }

        $users = User::whereIn('id', $request->user_ids)->get(['id']);
        $notification = new $notificationType->value($request->data);

        Notification::send($users, $notification);
        BlacklistedNotification::create(['idempotency_id' => $request->idempotency_id, 'created_at' => now()]);
    }
}
