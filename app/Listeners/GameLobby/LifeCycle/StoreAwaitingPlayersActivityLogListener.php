<?php

namespace App\Listeners\GameLobby\LifeCycle;

use App\Models\GameLobbyLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GameLobby\AwaitingPlayersEvent;

class StoreAwaitingPlayersActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(AwaitingPlayersEvent $event)
    {
        $gameLobbyLogs = GameLobbyLog::create([
            'name' => "Game Lobby State Awaiting Players",
            'description' => "The lobby state changed to AWAITING_PLAYERS State",
            'payload' => $event->gameLobby,
            'game_lobby_id' => $event->gameLobby->id,
            'user_id' => "8e94d65b-3588-41cd-9c18-4eb776b37be3",
        ]);
    }
}
