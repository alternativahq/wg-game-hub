<?php

namespace App\Notifications;

use App\Models\GameLobby;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class GameLobbyDistributedPrizesNotification extends Notification
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
            'title' => 'Prizes distributed for "' . $this->gameLobby->name . '"',
            'message' => 'Prizes for "' . $this->gameLobby->name . '" has been distributed. ',
        ];
    }
}
