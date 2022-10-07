<?php

namespace App\Http\QueryPipelines\GamesPipeline\Filters;

use Closure;
use Illuminate\Http\Request;
use App\Builders\GameBuilder;

class FilterByGameMode
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(GameBuilder $builder, Closure $next)
    {
        $filterTerm = $this->request->get('games_gamelobbies_type', null);

        if (!$filterTerm) {
            return $next($builder);
        }

        $builder->whereRelation('gameLobbies', 'type', $filterTerm);

        // $builder->where('type', $filterTerm);

        return $next($builder);
    }
}
