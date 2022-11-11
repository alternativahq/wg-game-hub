<?php

namespace App\Http\Controllers\API\Games;

use App\Models\Game;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Requests\StoreGameRequest;
use App\Http\Resources\GameAPIResource;
use App\Http\Requests\UpdateGameRequest;

class GamesController extends Controller
{
    public function index()
    {
        $games =  Game::withTrashed()->get();

        // $games = GamesPipeline::make(
        //     builder: Game::query(),
        //     request: $request,
        // )->withTrashed()->paginate();

                // 'q',
                // 'date',
                // 'sort_by',
                // 'sort_order',
                // 'min_players',
                // 'max_players',
                // 'min_base_entrance_fee',
                // 'max_base_entrance_fee',
                // 'games_gamelobbies_type',
                // 'games_gamelobbies_asset_symbol',

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
