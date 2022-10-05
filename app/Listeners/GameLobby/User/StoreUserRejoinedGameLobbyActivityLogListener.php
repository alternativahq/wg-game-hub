<?php

namespace App\Listeners\GameLobby\User;

use App\Models\GameLobbyLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GameLobby\UserRejoinedGameLobbyEvent;

class StoreUserRejoinedGameLobbyActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(UserRejoinedGameLobbyEvent $event)
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
