<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class AchievementBuilder extends Builder
{
    public function search($terms): static
    {
        collect(str_getcsv($terms, ' ', '"'))
            ->filter()
            ->each(function ($term) {
                $term = preg_replace('/[^A-Za-z0-9]/', '', $term) . '%';
                $this->whereIn('achievements.id', function ($query) use ($term) {
                    $query->select('id')->from(function ($query) use ($term) {
                        $query
                            ->select('id')
                            ->from('achievements')
                            ->where('achievements.name_normalized', 'like', $term);
                    }, 'matches');
                });
            });

        return $this;
    }
}
