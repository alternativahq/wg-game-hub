<?php

namespace App\Http\QueryPipelines\AdminGamesPipeline;

use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\AdminGamesPipeline\Filters\SortByName;
use App\Http\QueryPipelines\AdminGamesPipeline\Filters\SearchFilter;
use App\Http\QueryPipelines\AdminGamesPipeline\Filters\SortByStatus;
use App\Http\QueryPipelines\AdminGamesPipeline\Filters\SortByLobbyCount;

class AdminGamesPipeline extends Pipeline
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
