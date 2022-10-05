<?php

namespace App\Events\GameLobby;

use App\Models\GameLobby;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\GameLobbyResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameLobbyStartimeChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public function __construct(public GameLobby $gameLobby, public $payload)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('game-lobby.' . $this->gameLobby->id);
    }

    public function broadcastAs(): string
    {
        return 'gameLobby.starttime-changed';
    }

    public function broadcastWith(): array
    {
        return[ 
            'gameLobby' => $this->gameLobby,
        ];
    }
}
