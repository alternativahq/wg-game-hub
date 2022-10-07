<?php

namespace App\Http\QueryPipelines\GamesPipeline\Filters;

use App\Builders\GameBuilder;
use Closure;
use Illuminate\Http\Request;

class FilterByMinBaseEntranceFee
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(GameBuilder $builder, Closure $next)
    {
        $filterTerm = (int) $this->request->get('min_base_entrance_fee', null);
        if (!$filterTerm || $filterTerm < 0) {
            return $next($builder);
        }
        $builder->whereHas('gameLobbies', function($q) use($filterTerm){
            return $q->where('base_entrance_fee','>=', $filterTerm);
        });

        return $next($builder);
    }
}
