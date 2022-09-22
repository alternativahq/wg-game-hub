<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Inertia\Inertia;
use App\Models\GameLobby;
use App\Enums\GameLobbyType;
use Illuminate\Http\Request;
use App\Enums\GameLobbyStatus;
use App\Http\Resources\GameResource;
use App\Http\Resources\GameLobbyResource;
use App\Http\Resources\AdminGameLobbyResource;
use App\Http\QueryPipelines\GameLobbyPipeline\GameLobbyPipeline;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\AdminGameLobbiesPipeline;

class GamesController extends Controller
{
    public function show(Request $request, Game $game)
    {
        $gameTypes = GameLobbyType::toSelect();
        $gameLobbies = AdminGameLobbiesPipeline::make(
            builder: $game
                ->gameLobbies()
                ->whereIn('state', [GameLobbyStatus::AwaitingPlayers])
                ->getQuery(),
            request: $request,
        )
            ->with('asset:id,name,symbol')
            ->paginate();

        return Inertia::render('Games/Show', [
            'gameLobbies' => GameLobbyResource::collection($gameLobbies->withQueryString()),
            'gameTypes' => $gameTypes,
            'game' => new GameResource($game),
            'filters' => $request->only(
                'sort_by',
                'sort_order',
                'q',
                'game_lobbies_type',
                'min_players',
                'max_players',
                'date',
            ),
        ]);
    }
}
