<?php

namespace App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use Illuminate\Http\Request;

class FilterByDate
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $filterTerm = $this->request->get('date', []);
        $filterTerm = collect($filterTerm)->filter();

        if ($filterTerm->count() > 2 || $filterTerm->count() < 0) {
            return $next($builder);
        }

        if ($filterTerm->count() === 2) {
            $builder->whereHas('gameLobby', function($q) use($filterTerm){
                return $q->whereBetween('start_at', [
                    Carbon::create($filterTerm->first())->toDateTime(),
                    Carbon::create($filterTerm->last())->toDateTime(),
                ]);
            });
        }

        if ($filterTerm->count() === 1) {
            $builder->whereHas('gameLobby', function($q) use($filterTerm){
                return $q->whereBetween('start_at', [
                    Carbon::create($filterTerm->first())->startOfDay(),
                    Carbon::create($filterTerm->first())->endOfDay(),
                ]);
            });
        }

        return $next($builder);
    }
}
