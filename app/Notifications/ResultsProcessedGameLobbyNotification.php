<?php

namespace App\Notifications;

use App\Http\Resources\GameLobbyResource;
use App\Models\GameLobby;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Enums\NotificationType;

class ResultsProcessedGameLobbyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public GameLobby $gameLobby)
    {
        //
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' =>
                'Results for ' .
                $this->gameLobby->name .
                ' has been processed, You can see the results in your dashboard',
            'game_lobby' => new GameLobbyResource(new GameLobby($this->gameLobby->only('id', 'name'))),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'message' =>
                    'Results fo ' .
                    $this->gameLobby->name .
                    ' has been processed, You can see the results in your dashboard',
            ],
        ]);
    }
}
