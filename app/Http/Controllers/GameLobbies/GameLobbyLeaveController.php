<?php

namespace App\Http\Controllers\GameLobbies;

use App\Models\GameLobby;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\GameLobby\GameLobbyUserLeftGameLobbyEvent;
use App\Actions\Games\GameLobbies\RemoveUserFromGameLobbyAction;

class GameLobbyLeaveController extends Controller
{
    public function __invoke(
        Request $request,
        GameLobby $gameLobby,
        RemoveUserFromGameLobbyAction $removeUserFromGameLobbyAction,
    ) {
        $this->authorize('leave', $gameLobby);

        $gameLobby->load('asset');
        $gameLobby = $removeUserFromGameLobbyAction->execute(request: $request, gameLobby: $gameLobby);

        return redirect()->route('games.show', [
            'game' => $gameLobby->game_id,
        ]);
    }
}
