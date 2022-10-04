<?php

namespace App\Listeners;

use App\Models\GameLobbyLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GameLobby\GameLoobyCreatedEvent;

class GameLobbyCreatedListener
{
    public function __construct()
    {
        //
    }

    public function handle(GameLoobyCreatedEvent $event)
    {
        $gameLobbyLogs = GameLobbyLog::create([
            'name' => "Game Lobby Created",
            'description' => "A new game lobby is created by an admin or the system	",
            'payload' => $event->gameLobby,
            'game_lobby_id' => $event->gameLobby->id,
            'user_id' => auth()->user()->id,
        ]);
    }
}
