<?php

namespace App\Builders;

use App\Enums\GameLobbyStatus;
use Illuminate\Database\Eloquent\Builder;

class GameLobbyBuilder extends Builder
{
    public function whereAvailableForDashboard(): Builder
    {
        return $this->whereIn('status', [GameLobbyStatus::Scheduled, GameLobbyStatus::InLobby]);
    }
}
