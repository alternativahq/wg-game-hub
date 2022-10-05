<?php

namespace App\Listeners\GameLobby\Voting;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\GameLobby\Voting\GameLobbyStartVotingFailed;

class StoreGameLobbyStartVotingFailedActivityLogListener
{
    public function __construct()
    {
        //
    }

    public function handle(GameLobbyStartVotingFailed $event)
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
