<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use Inertia\Inertia;
use App\Enums\GameStatus;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminGameResource;
use App\Http\QueryPipelines\AdmingamesPipeline\AdmingamesPipeline;

class AdminGameController extends Controller
{
    public function __invoke(Request $request)
    {
        // $games = AdmingamesPipeline::make(
        //     builder: Game::withCount(['gameLobbies'])->get(['id', 'name', 'description', 'status']),
        //     request: $request,
        // );
        
        $games = Game::select(['id', 'name', 'status'])
            ->withCount(['gameLobbies'])
            ->paginate();

        return Inertia::render('Admin/Games', [
            'games' => AdminGameResource::collection($games),
            'filters' => $request->only('sort_by', 'sort_order', 'q'),
        ]);
    }
}
