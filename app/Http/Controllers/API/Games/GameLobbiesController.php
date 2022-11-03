<?php

namespace App\Http\Controllers\API\Games;

use App\Models\Game;
use Inertia\Inertia;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use App\Models\GameLobbyUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameLobbyResource;
use App\Http\Requests\ShowGameLobbyRequest;
use App\Http\QueryPipelines\GameLobbyPipeline\GameLobbyPipeline;

class GameLobbiesController extends Controller
{
    public function index(Request $request, Game $game)
    {
        $gameLobbies = GameLobbyPipeline::make(builder: $game->gameLobbies()->getQuery(), request: $request)
            ->with('asset:id,name,symbol')
            ->paginate();

        return GameLobbyResource::collection($gameLobbies);
    }

    public function show(ShowGameLobbyRequest $request, GameLobby $gameLobby)
    {
        if($request->includeUsers){
            $gameLobby->load('users:id,name,email,image,username');
        }
        if($request->includeGame){
            $gameLobby->load('game:id,name,description');
        }

        $gameLobby->prize_pool = $gameLobby->calculateThePrize();
        return new GameLobbyResource(resource: $gameLobby);
    }
}
