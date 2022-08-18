<?php

namespace App\Http\Controllers\API\Games;

use App\Actions\Games\GameLobbies\RemoveUserFromGameLobbyAction;
use App\Enums\Reactions\RemoveUserFromGameLobbyReaction;
use App\Http\Controllers\Controller;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GameLobbyLeaveController extends Controller
{
    public function __invoke(
        Request $request,
        GameLobby $gameLobby,
        RemoveUserFromGameLobbyAction $removeUserFromGameLobbyAction,
    ) {
        $this->authorize('leave', $gameLobby);

        $reaction = $removeUserFromGameLobbyAction->execute(request: $request, gameLobby: $gameLobby);

        abort_if($reaction instanceof RemoveUserFromGameLobbyReaction, 403, $reaction->label());

        return response()->noContent();
    }
}
