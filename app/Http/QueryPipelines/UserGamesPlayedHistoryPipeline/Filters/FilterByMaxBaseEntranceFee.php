<?php

namespace App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class FilterByMaxBaseEntranceFee
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $filterTerm = (int) $this->request->get('max_base_entrance_fee', null);

        if (!$filterTerm || $filterTerm < 0) {
            return $next($builder);
        }
        
        $builder->whereRelation('gameLobby','base_entrance_fee','<=',$filterTerm);

        return $next($builder);
    }
}
