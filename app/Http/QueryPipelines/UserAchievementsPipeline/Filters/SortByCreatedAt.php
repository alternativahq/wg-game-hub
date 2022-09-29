<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SortByCreatedAt
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Builder $builder, Closure $next)
    {
        $builder->when(
            $this->request->get('sort_by', null) &&
                $this->request->get('sort_by') === 'earned_at' &&
                in_array(strtolower($this->request->get('sort_order', null)), ['asc', 'desc']),
            function () use ($builder, $next) {
                $builder->orderBy('user_achievements.created_at', $this->request->get('sort_order'));
            },
        );

        return $next($builder);
    }
}
