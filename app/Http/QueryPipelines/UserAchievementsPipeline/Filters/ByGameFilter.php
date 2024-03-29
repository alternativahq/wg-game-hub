<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ByGameFilter
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Builder $builder, Closure $next)
    {
        $filterTerm = $this->request->get('filter_by_game', null);

        if (!$filterTerm) {
            return $next($builder);
        }

        $builder->where('achievements.game_id', $filterTerm);

        return $next($builder);
    }
}
