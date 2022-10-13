<?php

namespace App\Http\Controllers\User;

use App\Models\Game;
use App\Models\User;
use Inertia\Inertia;
use App\Enums\GameLobbyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\AchievementResource;
use App\Http\QueryPipelines\UserAchievementsPipeline\UserAchievementsPipeline;

class AchievementsController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        $achievements = UserAchievementsPipeline::make(
            builder: $user->achievements()->with(['game:id,name'])->getQuery(),
            request: $request
        );
        
        $gameTypes = GameLobbyType::toSelect();
        $games = Game::get(['id', 'name']);

        return Inertia::render('User/Achievements', [
            'userAchievements' => AchievementResource::collection($achievements->paginate()->withQueryString()),
            'games' => GameResource::collection($games),
            'gameTypes' => $gameTypes,
            'filters' => $request->only(
                'q',
                'rank',
                'date',
                'sort_by',
                'sort_order',
                'filter_by_game',
                'games_gamelobbies_type',
                'min_base_entrance_fee',
                'max_base_entrance_fee',
            ),
        ]);
    }
}
