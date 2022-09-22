<?php

namespace App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters;

use App\Builders\GameLobbyBuilder;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class FilterByDate
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(GameLobbyBuilder $builder, Closure $next)
    {
        $filterTerm = $this->request->get('date', []);
        $filterTerm = collect($filterTerm)->filter();

        if ($filterTerm->count() > 2 || $filterTerm->count() < 0) {
            return $next($builder);
        }

        if ($filterTerm->count() === 2) {
            $builder->whereBetween('start_at', [
                Carbon::create($filterTerm->first())->toDateTime(),
                Carbon::create($filterTerm->last())->toDateTime(),
            ]);
        }

        if ($filterTerm->count() === 1) {
            $builder->whereBetween('start_at', [
                Carbon::create($filterTerm->first())->startOfDay(),
                Carbon::create($filterTerm->first())->endOfDay(),
            ]);
        }

        return $next($builder);
    }
}
