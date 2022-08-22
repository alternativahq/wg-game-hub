<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use Inertia\Inertia;
use App\Enums\GameStatus;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminGameResource;
use App\Http\QueryPipelines\AdminGamesPipeline\AdminGamesPipeline;

class GamesController extends Controller
{
    public function __invoke(Request $request)
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
}
