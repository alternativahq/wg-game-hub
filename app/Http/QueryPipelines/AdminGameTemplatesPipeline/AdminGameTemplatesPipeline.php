<?php

namespace App\Http\QueryPipelines\AdminGameTemplatesPipeline;

use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\AdminGameTemplatesPipeline\Filters\SortByName;
use App\Http\QueryPipelines\AdminGameTemplatesPipeline\Filters\SortBySymbol;
use App\Http\QueryPipelines\AdminGameTemplatesPipeline\Filters\SortByBaseEntranceFee;
use App\Http\QueryPipelines\AdminGameTemplatesPipeline\Filters\SortByMinPlayers;
use App\Http\QueryPipelines\AdminGameTemplatesPipeline\Filters\SortByMaxPlayers;
use App\Http\QueryPipelines\AdminGameTemplatesPipeline\Filters\SearchFilter;

class AdminGameTemplatesPipeline extends Pipeline
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
            // new SortBySymbol(request: $this->request),
            new SortByBaseEntranceFee(request: $this->request),
            new SortByMinPlayers(request: $this->request),
            new SortByMaxPlayers(request: $this->request),
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
