<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use Inertia\Inertia;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\AdminGameLobbyResource;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\AdminGameLobbiesPipeline;


class GameLobbiesShowController extends Controller
{
    public function __invoke(Request $request, Game $game)
    {
        $gameLobbies = AdminGameLobbiesPipeline::make(
            builder: $game
                ->gameLobbies()
                ->getQuery(),
            request: $request,
        )
            ->with('asset:id,name,symbol')
            ->paginate();

        return Inertia::render('Admin/GameLobbies', [
            'gameLobbies' => AdminGameLobbyResource::collection($gameLobbies),
            'game' => $game,
            'filters' => $request->only('sort_by', 'sort_order'),
        ]);
    }
}
