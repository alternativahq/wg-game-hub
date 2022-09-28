<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SortByGameName
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $sortBy = $this->request->get('sort_by');
        $sortOrder = $this->request->get('sort_order', 'asc');

        if ($sortBy !== 'game_name') {
            return $next($builder);
        }

        if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
            return $next($builder);
        }

        // $builder->when($this->request->get('game_name'), function (Builder $builder, $sortOrder) {
        //     $builder->orderBy('user_achievements.game_id', $sortOrder);
        // });
        // $builder->orderBy('name', $sortOrder);
        $builder->orderBy('name', $sortOrder);

        return $next($builder);
    }
}
