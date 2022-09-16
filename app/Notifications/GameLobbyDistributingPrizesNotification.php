<?php

namespace App\Notifications;

use App\Models\GameLobby;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class GameLobbyDistributingPrizesNotification extends Notification
{
    public function __construct(public GameLobby $gameLobby)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        return $this->data();
    }

    public function toArray(): array
    {
        return $this->data();
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => $this->data(),
        ]);
    }

    protected function data()
    {
        return [
            'title' => 'Distributing prizes for "' . $this->gameLobby->name . '"',
            'message' =>
                'We started distributing prizes for "' .
                $this->gameLobby->name .
                '", you will receive your prize shortly.',
        ];
    }
}
