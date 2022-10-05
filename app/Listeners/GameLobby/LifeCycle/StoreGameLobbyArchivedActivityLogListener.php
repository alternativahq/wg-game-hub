<?php

namespace App\Listeners\GameLobby\LifeCycle;

use Illuminate\Queue\InteractsWithQueue;
use App\Events\GameLobby\GameArchivedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreGameLobbyArchivedActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(GameArchivedEvent $event)
    {
        // dd($event->gameLobby->id);
        // $gameLobbyLogs = GameLobbyLog::create([
        //     'name' => "Game Lobby Created",
        //     'description' => "A new game lobby is created by an admin or the system",
        //     'payload' => $event->gameLobby,
        //     'game_lobby_id' => $event->gameLobby->id,
        //     'user_id' => auth()->user()->id,
        // ]);
    }
}
