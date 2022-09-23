<?php

namespace App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters;

use App\Builders\GameLobbyBuilder;
use Closure;
use Illuminate\Http\Request;

class FilterByMinPlayers
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(GameLobbyBuilder $builder, Closure $next)
    {
        $filterTerm = (int) $this->request->get('min_players', null);
        if (!$filterTerm || $filterTerm < 0) {
            return $next($builder);
        }

        $builder->where('min_players','>=', $filterTerm);

        return $next($builder);
    }
}
