<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SortByAchievementName
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $builder->when(
            $this->request->get('sort_by', null) &&
                $this->request->get('sort_by') === 'achievement_name' &&
                in_array(strtolower($this->request->get('sort_order', null)), ['asc', 'desc']),
            function () use ($builder, $next) {
                $builder->orderBy('name', $this->request->get('sort_order'));
            },
        );
        return $next($builder);
    }
}
