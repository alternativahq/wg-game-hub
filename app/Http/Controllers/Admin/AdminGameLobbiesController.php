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
use App\Http\QueryPipelines\GameLobbyPipeline\GameLobbyPipeline;


class AdminGameLobbiesController extends Controller
{
    public function __invoke(Request $request, Game $game)
    {
        $gameLobbies = GameLobbyPipeline::make(
            builder: $game
                ->gameLobbies()
                ->whereIn('status', [
                    GameLobbyStatus::Scheduled,
                    GameLobbyStatus::InLobby,
                    GameLobbyStatus::InGame,
                ])
                ->getQuery(),
            request: $request,
        )
            ->with('asset:id,name,symbol')
            ->paginate();

        return Inertia::render('Admin/GameLobbies', [
            'gameLobbies' => AdminGameLobbyResource::collection($gameLobbies),
            'filters' => $request->only('sort_by', 'sort_order'),
        ]);
    }
}
