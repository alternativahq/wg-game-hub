<?php

namespace App\Http\Controllers;

use App\Enums\GameLobbyStatus;
use App\Enums\GameStatus;
use App\Http\Resources\ChatRoomResource;
use App\Http\Resources\GameResource;
use App\Models\ChatRoom;
use App\Models\Game;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $games = Game::where('status', GameStatus::Online)
            ->select(['id', 'name', 'description', 'image'])
            ->withCount([
                'gameLobbies' => function (Builder $builder) {
                    $builder->where('state', GameLobbyStatus::AwaitingPlayers);
                },
            ])
            ->paginate(pageName: 'games');

        return Inertia::render('Index', [
            'availableGames' => GameResource::collection($games),
            'mainChatRoom' => new ChatRoomResource(resource: ChatRoom::mainChannel()->first()),
        ]);
    }
}
