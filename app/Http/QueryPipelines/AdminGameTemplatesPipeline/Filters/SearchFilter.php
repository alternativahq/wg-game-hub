<?php

namespace App\Http\QueryPipelines\AdminGameTemplatesPipeline\Filters;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Builders\GameLobbyTemplatesBuilder;

class SearchFilter
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(GameLobbyTemplatesBuilder $builder, Closure $next)
    {
        $searchTerm = $this->request->get('q', null);

        if (!$searchTerm) {
            return $next($builder);
        }

        $builder->search($searchTerm);

        return $next($builder);
    }
}
