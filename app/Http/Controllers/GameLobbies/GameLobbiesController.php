<?php

namespace App\Http\Controllers\GameLobbies;

use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameLobbyResource;
use App\Models\GameLobby;
use App\Models\GameLobbyUser;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class GameLobbiesController extends Controller
{
    public function show(GameLobby $gameLobby)
    {
        $this->authorize('view', $gameLobby);

        return Inertia::render('Games/Lobbies/Show', [
            'gameLobby' => function () use ($gameLobby) {
                $gameLobby->load(
                    'game:id,name,description',
                    'users:id,name,last_name,image,username',
                    'asset:id,name,symbol',
                );

                if ($gameLobby->status === GameLobbyStatus::ResultsProcessed) {
                    // load the top 6 including the current user.
                    $gameLobby->load([
                        'scores' => function ($q) {
                            return $q->orderBy('rank')->limit(5);
                        },
                    ]);
                }
                return new GameLobbyResource($gameLobby);
            },
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
