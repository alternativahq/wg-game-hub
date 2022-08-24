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

    public function search($terms): static
    {
        collect(str_getcsv($terms, ' ', '"'))
            ->filter()
            ->each(function ($term) {
                $term = preg_replace('/[^A-Za-z0-9]/', '', $term) . '%';
                $this->whereIn('game_lobbies.id', function ($query) use ($term) {
                    $query->select('id')->from(function ($query) use ($term) {
                        $query
                            ->select('id')
                            ->from('game_lobbies')
                            ->where('game_lobbies.name_normalized', 'like', $term);
                    }, 'matches');
                });
            });

        return $this;
    }
}
