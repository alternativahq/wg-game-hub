<?php

namespace App\Http\Controllers\GameLobbies;

use App\Actions\Games\GameLobbies\RemoveUserFromGameLobbyAction;
use App\Http\Controllers\Controller;
use App\Models\GameLobby;
use Illuminate\Http\Request;

class GameLobbyLeaveController extends Controller
{
    public function __invoke(
        Request $request,
        GameLobby $gameLobby,
        RemoveUserFromGameLobbyAction $removeUserFromGameLobbyAction,
    ) {
        $this->authorize('leave', $gameLobby);

        $gameLobby = $removeUserFromGameLobbyAction->execute(
            request: $request,
            gameLobby: $gameLobby,
        );

        return redirect()->route('games.show', ['game' => $gameLobby->game_id]);
    }
}
