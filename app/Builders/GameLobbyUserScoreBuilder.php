<?php

namespace App\Builders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class GameLobbyUserScoreBuilder extends Builder
{
    public function topThreePlayedGamesWithTotalTimePlayed(User $user): self
    {
        return $this->where('user_id', $user->id)
            ->selectRaw('game_id, sum(time_played) as total_time_played')
            ->groupBy('game_id')
            ->orderBy('total_time_played', 'DESC')
            ->with('game:id,name')
            ->take(3);
    }
}
