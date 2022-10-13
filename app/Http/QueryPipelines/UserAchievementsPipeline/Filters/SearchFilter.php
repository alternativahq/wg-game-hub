<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline\Filters;

use App\Builders\AchievementBuilder;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchFilter
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(AchievementBuilder $builder, Closure $next)
    {
        $searchTerm = $this->request->get('q', null);

        if (!$searchTerm) {
            return $next($builder);
        }

        $builder->search($searchTerm);

        return $next($builder);
    }
}
