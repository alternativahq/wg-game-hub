<?php

namespace App\Listeners\GameLobby\User;

use App\Models\GameLobbyLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GameLobby\UserJoinedGameLobbyEvent;

class StoreUserJoinedGameLobbyActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(UserJoinedGameLobbyEvent $event)
    {
        // dd($event);
        // $gameLobbyLogs = GameLobbyLog::create([
        //     'name' => "User joined",
        //     'description' => "A specific user joined the lobby",
        //     'payload' => $event->gameLobby,
        //     'game_lobby_id' => $event->gameLobby->id,
        //     'user_id' => auth()->user()->id,
        // ]);
    }
}
