<?php

namespace App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SortBySymbol
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Builder $builder, Closure $next)
    {
        $sortBy = $this->request->get('sort_by');
        $sortOrder = $this->request->get('sort_order', 'asc');

        if ($sortBy !== 'game_lobbies_asset_symbol') {
            return $next($builder);
        }

        if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
            return $next($builder);
        }

        $builder->whereHas('asset', function ($q) use ($sortOrder) {
            return $q->orderBy('symbol', $sortOrder);
        });
        // $builder->orderBy('game_lobbies.asset.symbol', $sortOrder);

        return $next($builder);
    }
}
