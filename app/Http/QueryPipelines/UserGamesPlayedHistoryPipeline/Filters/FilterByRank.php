<?php

namespace App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters;

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
        
        $builder->whereRelation('gameLobby','rank','<=',$filterTerm);

        return $next($builder);
    }
}
