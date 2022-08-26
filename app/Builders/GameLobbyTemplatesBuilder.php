<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class GameLobbyTemplatesBuilder extends Builder
{
    public function search($terms): static
    {
        collect(str_getcsv($terms, ' ', '"'))
            ->filter()
            ->each(function ($term) {
                $term = preg_replace('/[^A-Za-z0-9]/', '', $term) . '%';
                $this->whereIn('game_lobby_templates.id', function ($query) use ($term) {
                    $query->select('id')->from(function ($query) use ($term) {
                        $query
                            ->select('id')
                            ->from('game_lobby_templates')
                            ->where('game_lobby_templates.name_normalized', 'like', $term);
                    }, 'matches');
                });
            });

        return $this;
    }
}
