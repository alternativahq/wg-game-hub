<?php

namespace App\Listeners\GameLobby\User;

use App\Models\GameLobbyLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GameLobby\UserLeftGameLobbyEvent;

class UserLeftGameLobbyListener
{
    public function __construct()
    {
        //
    }

    public function handle(UserLeftGameLobbyEvent $event)
    {
        $gameLobbyLogs = GameLobbyLog::create([
            'name' => "User left",
            'description' => "A specific user left the lobby",
            'payload' => $event->gameLobby,
            'game_lobby_id' => $event->gameLobby->id,
            'user_id' => auth()->user()->id,
        ]);
    }
}
