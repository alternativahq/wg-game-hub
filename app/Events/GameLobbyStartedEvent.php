<?php

namespace App\Events;

use App\Models\GameLobby;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameLobbyStartedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public GameLobby $gameLobby, public string $url)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PresenceChannel('game-lobby.' . $this->gameLobby->id);
    }

    public function broadcastAs(): string
    {
        return 'status.in-game';
    }

    public function broadcastWith(): array
    {
        return [
            'url' => $this->url,
        ];
    }
}
