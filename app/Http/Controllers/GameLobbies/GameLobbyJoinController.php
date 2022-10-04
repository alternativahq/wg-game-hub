<?php

namespace App\Http\Controllers\GameLobbies;

use Auth;
use Redirect;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\GameLobby\UserJoinedGameLobbyEvent;
use App\Enums\Reactions\AddUserToGameLobbyReaction;
use App\Actions\Games\GameLobbies\AddUserToGameLobbyAction;

class GameLobbyJoinController extends Controller
{
    public function __invoke(Request $request, GameLobby $gameLobby, AddUserToGameLobbyAction $addUserToGameLobbyAction)
    {
        $this->authorize('join', $gameLobby);
        $gameLobby->load('asset');
        /** @var \App\Enums\Reactions\AddUserToGameLobbyReaction|GameLobby $reaction */
        $reaction = $addUserToGameLobbyAction->execute(user: Auth::user(), gameLobby: $gameLobby);

        if ($reaction instanceof AddUserToGameLobbyReaction) {
            session()->flash('error', $reaction->label());
            return Redirect::route('games.show', [
                'game' => $gameLobby->game_id,
            ]);
        }
        
        event(new UserJoinedGameLobbyEvent($gameLobby, auth()->user(), 2));

        return Redirect::route('game-lobbies.show', [
            'gameLobby' => $gameLobby,
        ]);
    }
}
