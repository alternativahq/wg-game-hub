<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline\Filters;

use Illuminate\Database\Eloquent\Builder;
use Closure;
use Illuminate\Http\Request;

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

        $builder->where('base_entrance_fee', '<=', $filterTerm);

        return $next($builder);
    }
}
