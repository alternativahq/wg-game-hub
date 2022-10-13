<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
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
            $builder->whereBetween('user_achievements.created_at', [
                Carbon::create($filterTerm->first())->toDateTime(),
                Carbon::create($filterTerm->last())->toDateTime(),
            ]);
        }

        if ($filterTerm->count() === 1) {
            $builder->whereBetween('user_achievements.created_at', [
                Carbon::create($filterTerm->first())->startOfDay(),
                Carbon::create($filterTerm->first())->endOfDay(),
            ]);
        }

        return $next($builder);
    }
}
