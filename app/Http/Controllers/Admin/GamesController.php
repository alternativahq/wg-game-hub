<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use Inertia\Inertia;
use App\Enums\GameStatus;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminGameResource;
use App\Http\Resources\AdminGameLobbyResource;

use App\Http\Resources\AdminGameLobbyTemplateResource;
use App\Http\QueryPipelines\AdminGamesPipeline\AdminGamesPipeline;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\AdminGameLobbiesPipeline;
use App\Http\QueryPipelines\AdminGameTemplatesPipeline\AdminGameTemplatesPipeline;

class GamesController extends Controller
{
    public function index(Request $request)
    {
        $games = AdminGamesPipeline::make(
            builder: Game::withCount(['gameLobbies']),
            request: $request,
        );

        return Inertia::render('Admin/Games', [
            'games' => AdminGameResource::collection($games->paginate()->withQueryString()),
            'filters' => $request->only('sort_by', 'sort_order', 'q'),
        ]);
    }

    public function showLobbies(Request $request, Game $game)
    {
        $gameLobbies = AdminGameLobbiesPipeline::make(
            builder: $game
                ->gameLobbies()
                ->getQuery(),
            request: $request,
        )
            ->with('asset:id,name,symbol')
            ->paginate();

        return Inertia::render('Admin/Lobbies/GameLobbies', [
            'gameLobbies' => AdminGameLobbyResource::collection($gameLobbies->withQueryString()),
            'game' => $game,
            'filters' => $request->only('sort_by', 'sort_order','q'),
        ]);
    }

    public function showTemplates(Request $request, Game $game)
    {
        $gameTemplates = AdminGameTemplatesPipeline::make(
            builder: $game
                ->gameTemplates()
                ->getQuery(),
            request: $request,
        )
            ->with('asset:id,name,symbol')
            ->paginate();

        return Inertia::render('Admin/Template/GameTemplates', [
            'gameTemplates' => AdminGameLobbyTemplateResource::collection($gameTemplates->withQueryString()),
            'game' => $game,
            'filters' => $request->only('sort_by', 'sort_order','q'),
        ]);
    }
}