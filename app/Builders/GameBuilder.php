<?php

namespace App\Builders;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Builder;

class GameBuilder extends Builder
{
    public function online(): Builder
    {
        return $this->where('status', GameStatus::Online->value);
    }

    public function forDashboard(): Builder
    {
        return $this->select(['id', 'name', 'description', 'image']);
    }

    public function search($terms): static
    {
        collect(str_getcsv($terms, ' ', '"'))
            ->filter()
            ->each(function ($term) {
                $term = preg_replace('/[^A-Za-z0-9]/', '', $term) . '%';
                $this->whereIn('games.id', function ($query) use ($term) {
                    $query->select('id')->from(function ($query) use ($term) {
                        $query
                            ->select('id')
                            ->from('games')
                            ->where('games.name_normalized', 'like', $term);
                    }, 'matches');
                });
            });

        return $this;
    }
}
