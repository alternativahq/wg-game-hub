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
        $request->validate([
            'url' => ['required', 'url'],
        ]);

        if (!$gameLobby->state->is(GameLobbyStatus::AwaitingPlayers)) {
            return abort(Response::HTTP_UNAUTHORIZED);
        }

        $gameLobby->state = GameLobbyStatus::InGame;

        if (!$gameLobby->save()) {
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Could not update game settings');
        }

        broadcast(new GameLobbyStartedEvent(gameLobby: $gameLobby, url: $request->url));

        return response()->noContent();
    }
}
