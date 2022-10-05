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
        // dd($event->gameLobby->id);
        // $gameLobbyLogs = GameLobbyLog::create([
        //     'name' => "Game Lobby State in-game",
        //     'description' => "The lobby state changed to IN_GAME State",
        //     'payload' => $event->gameLobby,
        //     'game_lobby_id' => $event->gameLobby->id,
        //     'user_id' => auth()->user()->id,
        // ]);
    }
}
