<?php

namespace App\Http\QueryPipelines\GamesPipeline\Filters;

use App\Builders\GameBuilder;
use Closure;
use Illuminate\Http\Request;

class FilterByAsset
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(GameBuilder $builder, Closure $next)
    {
        $filterTerm = $this->request->get('games_gamelobbies_asset_symbol', null);
        if (!$filterTerm) {
            return $next($builder);
        }

        $builder->whereHas('gameLobbies', function($q) use($filterTerm){
            return $q->whereHas('asset', function($q) use($filterTerm){
                $q->where('symbol',$filterTerm);
            });
        });

        return $next($builder);
    }
}
