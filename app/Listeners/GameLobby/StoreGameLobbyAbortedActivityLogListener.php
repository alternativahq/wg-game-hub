<?php

namespace App\Listeners\GameLobby;

use Illuminate\Queue\InteractsWithQueue;
use App\Events\GameLobby\GameLobbyAborted;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreGameLobbyAbortedActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(GameLobbyAborted $event)
    {
        dd($event);
        // $gameLobbyLogs = GameLobbyLog::create([
        //     'name' => "User Rejoined",
        //     'description' => "A specific user left the lobby",
        //     'payload' => $event->gameLobby,
        //     'game_lobby_id' => $event->gameLobby->id,
        //     'user_id' => auth()->user()->id,
        // ]);
    }
}
