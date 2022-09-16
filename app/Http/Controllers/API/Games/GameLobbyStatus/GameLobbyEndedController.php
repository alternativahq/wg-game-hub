<?php

namespace App\Http\Controllers\API\Games\GameLobbyStatus;

use App\Enums\GameLobbyStatus;
use App\Events\GameLobbyArchivedEvent;
use App\Events\GameLobbyStartedEvent;
use App\Http\Controllers\Controller;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class GameLobbyEndedController extends Controller
{
    public function __invoke(Request $request, GameLobby $gameLobby)
    {
        if (!$gameLobby->state->is(GameLobbyStatus::DistributingPrizes)) {
            return abort(Response::HTTP_UNAUTHORIZED);
        }
        $gameLobby->state = GameLobbyStatus::Archived;

        if (!$gameLobby->save()) {
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Could not update game settings');
        }

        $gameLobby->load('users');

        broadcast(new GameLobbyArchivedEvent(gameLobby: $gameLobby));

        return response()->noContent();
    }
}
