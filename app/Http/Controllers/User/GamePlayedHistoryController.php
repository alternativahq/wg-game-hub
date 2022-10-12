<?php

namespace App\Http\Controllers\User;

use App\Models\Game;
use App\Models\User;
use Inertia\Inertia;
use App\Enums\GameLobbyType;
use Illuminate\Http\Request;
use App\Models\GameLobbyUserScore;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\UserScoreResource;
use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\UserGamesPlayedHistoryPipeline;

class GamePlayedHistoryController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        $userScoreBuilder = GameLobbyUserScore::query()->whereBelongsTo($user);

        $gamePlayedHistory = UserGamesPlayedHistoryPipeline::make(
            builder: $userScoreBuilder->with(['game:id,name', 'gameLobby']),
            request: $request,
        );

        $gameTypes = GameLobbyType::toSelect();
        $games = Game::get(['id', 'name']);

        return Inertia::render('User/GamesPlayedHistory', [
            'userGamesPlayedHistory' => UserScoreResource::collection(
                $gamePlayedHistory->paginate()->withQueryString(),
            ),
            'games' => GameResource::collection($games),
            'gameTypes' => $gameTypes,
            'filters' => $request->only(
                'q',
                'rank',
                'date',
                'sort_by',
                'sort_order',
                'filter_by_game',
                'game_gamelobbies_type',
                'min_base_entrance_fee',
                'max_base_entrance_fee',
            ),
        ]);
    }
}
