<?php

namespace App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class FilterDateFrom
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $filterTerm = $this->request->get('date_from', []);
        $filterTerm = collect($filterTerm)->filter();

        if ($filterTerm->count() > 1 || $filterTerm->count() < 0) {
            return $next($builder);
        }

        if ($filterTerm->count() === 1) {
            $builder->whereHas('gameLobby', function($q) use($filterTerm){
                return $q->where('start_at', ">", $filterTerm->first());
            });
        }

        return $next($builder);
    }
}
