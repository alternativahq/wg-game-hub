<?php

namespace App\Listeners\GameLobby\LifeCycle;

use App\Models\GameLobbyLog;
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
        $gameLobbyLogs = GameLobbyLog::create([
            'name' => "Game Lobby Archived",
            'description' => "The lobby state changed to ARCHIVED State",
            'payload' => $event->gameLobby,
            'game_lobby_id' => $event->gameLobby->id,
            'user_id' => "8e94d65b-3588-41cd-9c18-4eb776b37be3",
        ]);
    }
}
