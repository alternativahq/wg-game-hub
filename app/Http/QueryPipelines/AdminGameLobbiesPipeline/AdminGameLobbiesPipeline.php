<?php

namespace App\Http\QueryPipelines\AdminGameLobbiesPipeline;

use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters\SortByName;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters\SortByType;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters\SortByStatus;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters\SortBySymbol;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters\SortByBaseEntranceFee;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters\SortByMinPlayers;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters\SortByMaxPlayers;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters\SortByScheduledAt;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\Filters\SearchFilter;

class AdminGameLobbiesPipeline extends Pipeline
{
    protected ?Request $request;

    public function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    protected function pipes()
    {
        return [
            new SortByName(request: $this->request),
            new SortByType(request: $this->request),
            new SortByStatus(request: $this->request),
            // new SortBySymbol(request: $this->request),
            new SortByBaseEntranceFee(request: $this->request),
            new SortByMinPlayers(request: $this->request),
            new SortByMaxPlayers(request: $this->request),
            new SortByScheduledAt(request: $this->request),
            new SearchFilter(request: $this->request),
        ];
    }

    public static function make(Builder $builder, Request $request): Builder
    {
        return app(static::class)
            ->setRequest(request: $request)
            ->send($builder)
            ->thenReturn();
    }
}
