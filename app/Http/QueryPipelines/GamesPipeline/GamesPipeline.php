<?php

namespace App\Http\QueryPipelines\GamesPipeline;

use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\GamesPipeline\Filters\SearchFilter;
use App\Http\QueryPipelines\GamesPipeline\Filters\FilterByGameMode;
use App\Http\QueryPipelines\GamesPipeline\Filters\FilterByDate;
use App\Http\QueryPipelines\GamesPipeline\Filters\FilterByAsset;
use App\Http\QueryPipelines\GamesPipeline\Filters\FilterByMaxPlayers;
use App\Http\QueryPipelines\GamesPipeline\Filters\FilterByMinPlayers;
use App\Http\QueryPipelines\GamesPipeline\Filters\FilterByMaxBaseEntranceFee;
use App\Http\QueryPipelines\GamesPipeline\Filters\FilterByMinBaseEntranceFee;

class GamesPipeline extends Pipeline
{
    protected ?Request $request;

    public function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    protected function pipes(): array
    {
        return [
            new SearchFilter(request: $this->request),
            new FilterByGameMode(request: $this->request),
            new FilterByAsset(request: $this->request),
            new FilterByMaxBaseEntranceFee(request: $this->request),
            new FilterByMinBaseEntranceFee(request: $this->request),
            new FilterByMinPlayers(request: $this->request),
            new FilterByMaxPlayers(request: $this->request),
            new FilterByDate(request: $this->request),
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
