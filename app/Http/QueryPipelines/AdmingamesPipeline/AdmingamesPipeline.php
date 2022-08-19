<?php

namespace App\Http\QueryPipelines\AdmingamesPipeline;

use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\AdmingamesPipeline\Filters\SortByName;
use App\Http\QueryPipelines\AdmingamesPipeline\Filters\SearchFilter;
use App\Http\QueryPipelines\AdmingamesPipeline\Filters\SortByStatus;
use App\Http\QueryPipelines\AdmingamesPipeline\Filters\SortByLobbyCount;

class AdmingamesPipeline extends Pipeline
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
            new SearchFilter(request: $this->request),
            new SortByStatus(request: $this->request),
            new SortByLobbyCount(request: $this->request),
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
