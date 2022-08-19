<?php

namespace App\Http\Controllers\API\Games;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\Game;

class GamesController extends Controller
{
    public function index()
    {
        $games = Game::online()
            ->withCount('gameLobbies')
            ->select(['id', 'name', 'image'])
            ->paginate();

        return GameResource::collection($games);
    }

    public function show(Game $game)
    {
        return new GameResource($game);
    }
}
