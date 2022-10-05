<?php

namespace App\Listeners\GameLobby\LifeCycle;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GameLobby\DistributingPrizesEvent;

class StoreGameLobbyDistributingPrizesActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(DistributingPrizesEvent $event)
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
