<?php

namespace App\Events\GameLobby\Voting;

use App\Models\GameLobby;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\GameLobbyResource;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameLobbyStartVotingFailed
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
        return 'gameLobby.start-voting-failed';
    }
    
    public function broadcastWith(): array
    {
        return[ 
            'gameLobby' => (new GameLobbyResource($this->gameLobby))->resolve(),
        ];
    }
}
