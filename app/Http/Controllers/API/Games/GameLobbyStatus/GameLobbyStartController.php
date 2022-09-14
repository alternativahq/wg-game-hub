<?php

namespace App\Http\Controllers\API\Games\GameLobbyStatus;

use App\Enums\GameLobbyStatus;
use App\Events\GameLobbyStartedEvent;
use App\Http\Controllers\Controller;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GameLobbyStartController extends Controller
{
    public function __invoke(Request $request, GameLobby $gameLobby)
    {
        if (!$gameLobby->status->is(GameLobbyStatus::InLobby)) {
            return abort(Response::HTTP_UNAUTHORIZED);
        }

        $gameLobby->status = GameLobbyStatus::InGame;

        if (!$gameLobby->save()) {
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Could not update game settings');
        }

        // TODO: Request to game server
        broadcast(new GameLobbyStartedEvent(gameLobby: $gameLobby));

        return response()->noContent();
    }
}
