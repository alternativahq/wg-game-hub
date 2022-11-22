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

class GameLobbyProcessingGameResultsEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(public GameLobby $gameLobby)
    {
    }
}
