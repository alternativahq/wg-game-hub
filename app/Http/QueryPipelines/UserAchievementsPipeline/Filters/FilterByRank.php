<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline\Filters;

use Illuminate\Database\Eloquent\Builder;
use Closure;
use Illuminate\Http\Request;

class FilterByRank
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $filterTerm = (int) $this->request->get('rank', null);

        if (!$filterTerm || $filterTerm < 0) {
            return $next($builder);
        }

        $builder->whereHas('usersAchievements', function($q) use($filterTerm) {
            return $builder->whereRelation('gameLobby','rank',$filterTerm);
        });
        // dd($builder);
        // $builder->whereRelation('gameLobby','rank',$filterTerm);

        return $next($builder);
    }
}
