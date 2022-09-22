<?php

namespace App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters;

use App\Builders\GameLobbyBuilder;
use Closure;
use Illuminate\Http\Request;

class FilterByAsset
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(GameLobbyBuilder $builder, Closure $next)
    {
        // dd($this->request->all());
        $filterTerm = $this->request->get('asset_symbol', null);
        if (!$filterTerm) {
            return $next($builder);
        }

        // $builder->whereHas('asset', function($q) use($filterTerm){
        //     return $q->where('id',$filterTerm);
        // });
        $builder->whereRelation('asset', 'symbol', $filterTerm);

        return $next($builder);
    }
}
