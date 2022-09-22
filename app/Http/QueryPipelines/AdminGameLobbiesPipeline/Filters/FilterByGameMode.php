<?php

namespace App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters;

use App\Builders\GameLobbyBuilder;
use Closure;
use Illuminate\Http\Request;

class FilterByGameMode
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(GameLobbyBuilder $builder, Closure $next)
    {
        $filterTerm = $this->request->get('game_lobbies_type', null);

        if (!$filterTerm) {
            return $next($builder);
        }

        $builder->where('type', $filterTerm);

        return $next($builder);
    }
}
