<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class RemoteNotification extends Notification
{
    public function __construct(public array $data)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        return $this->data;
    }

    public function toArray($notifiable): array
    {
        return $this->data;
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->data);
    }
}
