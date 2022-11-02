<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Inertia\Inertia;
use App\Models\Asset;
use App\Models\ChatRoom;
use App\Enums\GameStatus;
use App\Enums\GameLobbyType;
use Illuminate\Http\Request;
use App\Enums\GameLobbyStatus;
use App\Http\Resources\GameResource;
use App\Http\Resources\ChatRoomResource;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\GamesPipeline\GamesPipeline;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $assets = Asset::get(['id', 'name', 'symbol']);
        $gameTypes = GameLobbyType::toSelect();
        $games = GamesPipeline::make(
            builder: Game::query()->where('status', GameStatus::Online)->whereHas("gameLobbies",function (Builder $builder) {
                        $builder->where('state', GameLobbyStatus::AwaitingPlayers);
                    }),
            request: $request,
        )->paginate();

        return Inertia::render('Index', [
            'availableGames' => GameResource::collection($games),
            'mainChatRoom' => new ChatRoomResource(resource: ChatRoom::mainChannel()->first()),
            'gameTypes' => $gameTypes,
            'assets' => $assets,
            'filters' => $request->only(
                'q',
                'date',
                'sort_by',
                'sort_order',
                'min_players',
                'max_players',
                'min_base_entrance_fee',
                'max_base_entrance_fee',
                'games_gamelobbies_type',
                'games_gamelobbies_asset_symbol',
            ),
        ]);
    }
}
