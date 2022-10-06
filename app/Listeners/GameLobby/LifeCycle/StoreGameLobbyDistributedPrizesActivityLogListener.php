<?php

namespace App\Listeners\GameLobby\LifeCycle;

use App\Models\GameLobbyLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GameLobby\DistributedPrizesEvent;

class StoreGameLobbyDistributedPrizesActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(DistributedPrizesEvent $event)
    {
        $gameLobbyLogs = GameLobbyLog::create([
            'name' => "Game Lobby Distributed Prizes",
            'description' => "The lobby state changed to DISTRIBUTED_PRIZES State",
            'payload' => $event->gameLobby,
            'game_lobby_id' => $event->gameLobby->id,
            'user_id' => "8e94d65b-3588-41cd-9c18-4eb776b37be3",
        ]);
    }
}
