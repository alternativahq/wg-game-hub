<?php

namespace App\Http\QueryPipelines\GamesPipeline\Filters;

use Closure;
use Illuminate\Http\Request;
use App\Builders\GameBuilder;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(GameBuilder $builder, Closure $next)
    {
        $searchTerm = $this->request->get('q', null);

        if (!$searchTerm) {
            return $next($builder);
        }

        $builder->search($searchTerm);

        return $next($builder);
    }
}
