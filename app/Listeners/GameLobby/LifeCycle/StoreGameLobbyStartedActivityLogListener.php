<?php

namespace App\Listeners\GameLobby\LifeCycle;

use App\Models\GameLobbyLog;
use App\Events\GameLobbyStartedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreGameLobbyStartedActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(GameLobbyStartedEvent $event)
    {
        $gameLobbyLogs = GameLobbyLog::create([
            'name' => "Game Lobby State in-game",
            'description' => "The lobby state changed to IN_GAME State",
            'payload' => $event->gameLobby,
            'game_lobby_id' => $event->gameLobby->id,
            'user_id' => "8e94d65b-3588-41cd-9c18-4eb776b37be3",
        ]);
    }
}
