<?php

namespace App\Http\Controllers\GameLobbies;

use Auth;
use Inertia\Inertia;
use App\Models\GameLobby;
use App\Models\GameLobbyUser;
use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameLobbyResource;
use Illuminate\Database\Eloquent\Builder;

class GameLobbiesController extends Controller
{
    public function show(GameLobby $gameLobby)
    {
        $this->authorize('view', $gameLobby);

        if(
            $gameLobby->state->is(GameLobbyStatus::GameLobbyAbortedRefunding) ||
            $gameLobby->state->is(GameLobbyStatus::GameLobbyAborted)
        ){
            return redirect()->route('games.show',$gameLobby->game->id);
        }

        $gameLobby->load(
            'game:id,name,description',
            'users:id,name,last_name,image,username',
            'asset:id,name,symbol',
        );

        if (
            $gameLobby->state->is(GameLobbyStatus::GameEnded) ||
            $gameLobby->state->is(GameLobbyStatus::DistributingPrizes) ||
            $gameLobby->state->is(GameLobbyStatus::DistributedPrizes)
        ) {
            // load the top 6 including the current user.
            $gameLobby->load([
                'scores' => function ($q) {
                    return $q->orderBy('rank')->limit(5);
                },
            ]);
        }

        return Inertia::render('Games/Lobbies/Show', [
            'gameLobby' => new GameLobbyResource($gameLobby),
            'currentUserScore' => function () use ($gameLobby) {
                return auth()->user()
                    ? $gameLobby
                        ->scores()
                        ->where('user_id', auth()->user()->id)
                        ->first()
                    : [];
            },
            'prize' => $gameLobby->calculateThePrize(),
        ]);
    }
}
