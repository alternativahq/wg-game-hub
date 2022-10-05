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
        // dd($event->gameLobby->id);
        // $gameLobbyLogs = GameLobbyLog::create([
        //     'name' => "Game Lobby State Awaiting Players",
        //     'description' => "The lobby state changed to AWAITING_PLAYERS State",
        //     'payload' => $event->gameLobby,
        //     'game_lobby_id' => $event->gameLobby->id,
        //     'user_id' => auth()->user()->id,
        // ]);
    }
}
