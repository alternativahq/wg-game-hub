<?php

namespace App\Events\GameLobby;

use App\Models\GameLobby;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameEndedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public GameLobby $gameLobby)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PresenceChannel('game-lobby.' . $this->gameLobby->id);
    }

    public function broadcastAs(): string
    {
        return 'status.game-ended';
    }
}
