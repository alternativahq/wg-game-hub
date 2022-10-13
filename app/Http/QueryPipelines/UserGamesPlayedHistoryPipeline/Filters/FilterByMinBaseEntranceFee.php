<?php

namespace App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters;

use Illuminate\Database\Eloquent\Builder;
use Closure;
use Illuminate\Http\Request;

class FilterByMinBaseEntranceFee
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $filterTerm = (int) $this->request->get('min_base_entrance_fee', null);
        if (!$filterTerm || $filterTerm < 0) {
            return $next($builder);
        }

        $builder->whereRelation('gameLobby','base_entrance_fee','>=',$filterTerm);

        return $next($builder);
    }
}
