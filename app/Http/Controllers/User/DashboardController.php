<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\GameLobbyUser;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\GameLobbyUserScore;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(User $user): Response
    {
        $totalTimePlayed = GameLobbyUserScore::whereBelongsTo($user)->sum('time_played');

        $topThreePlayedGamesAndTotalTimePlayed = GameLobbyUserScore::topThreePlayedGamesWithTotalTimePlayed(
            user: $user,
        )->get();

        $lastLobbyPlayedIn = $user
            ->gameLobbies()
            ->latest()
            ->with('game')
            ->first();

        $achievements = UserAchievement::whereBelongsTo($user)
            ->latest()
            ->with(['game:id,name', 'achievement:id,name,description'])
            ->take(5)
            ->get();

        $gamePlayedHistory = GameLobbyUserScore::whereBelongsTo($user)
            ->latest()
            ->with(['game:id,name', 'gameLobby:id,created_at,scheduled_at'])
            ->take(5)
            ->get();

        return Inertia::render('User/Dashboard', [
            'user' => $user->only('image_url', 'status', 'full_name', 'username'),
            'totalPlayed' => GameLobbyUser::whereBelongsTo($user)->count(),
            'totalTimePlayed' => (int) $totalTimePlayed,
            'topPlayedGamesTimeSpent' => $topThreePlayedGamesAndTotalTimePlayed,
            'lastGamePlayed' => $lastLobbyPlayedIn?->game,
            'latestAchievements' => $achievements,
            'latestGamesPlayedHistory' => $gamePlayedHistory,
        ]);
    }
}
