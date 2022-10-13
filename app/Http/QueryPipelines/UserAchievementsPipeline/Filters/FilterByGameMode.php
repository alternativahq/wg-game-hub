<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline\Filters;

use Illuminate\Database\Eloquent\Builder;
use Closure;
use Illuminate\Http\Request;

class FilterByGameMode
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $filterTerm = $this->request->get('game_lobbies_type', null);

        if (!$filterTerm) {
            return $next($builder);
        }

        $builder->whereRelation('gameLobby', 'type', $filterTerm);

        return $next($builder);
    }
}
