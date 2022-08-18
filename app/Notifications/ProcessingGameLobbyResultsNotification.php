<?php

namespace App\Notifications;

use App\Http\Resources\GameLobbyResource;
use App\Models\GameLobby;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ProcessingGameLobbyResultsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public GameLobby $gameLobby)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' =>
                'We are processing, ' . $this->gameLobby->name . ' results. We will notify you once results are ready',
            'game_lobby' => new GameLobbyResource(new GameLobby($this->gameLobby->only('id', 'name'))),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'message' => 'We are processing, ' .  $this->gameLobby->name . ' results. We will notify you once results are ready',
            ],
        ]);
    }
}
