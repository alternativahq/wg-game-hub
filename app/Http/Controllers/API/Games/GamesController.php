<?php

namespace App\Http\Controllers\API\Games;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Requests\StoreGameRequest;
use App\Http\Resources\GameAPIResource;
use App\Http\Requests\UpdateGameRequest;
use App\Http\QueryPipelines\GamesPipeline\GamesPipeline;

class GamesController extends Controller
{
    public function index(Request $request)
    {
        $games = GamesPipeline::make(
            builder: Game::query()->withTrashed(),
            request: $request,
        )->paginate();

        return GameAPIResource::collection($games);
    }

    public function show(Game $game)
    {
        return response()->json(new GameAPIResource(resource: $game));
    }


    public function store(StoreGameRequest $request)
    {
        $game = Game::create($request->validated());
        return response()->json(new GameAPIResource($game));
    }

    public function update(UpdateGameRequest $request, Game $game)
    {
        $game->update($request->validated());
        return response()->json(new GameAPIResource(resource: $game));
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return response()->noContent();
    }
}
