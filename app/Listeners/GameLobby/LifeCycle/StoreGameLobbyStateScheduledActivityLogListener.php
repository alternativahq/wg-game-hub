<?php

namespace App\Listeners\GameLobby\LifeCycle;

use App\Models\GameLobbyLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GameLobby\StateScheduledEvent;

class StoreGameLobbyStateScheduledActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(StateScheduledEvent $event)
    {
        dd($event->gameLobby->id);
        $gameLobbyLogs = GameLobbyLog::create([
            'name' => "Game Lobby Created",
            'description' => "A new game lobby is created by an admin or the system",
            'payload' => $event->gameLobby,
            'game_lobby_id' => $event->gameLobby->id,
            'user_id' => auth()->user()->id,
        ]);
    }
}
