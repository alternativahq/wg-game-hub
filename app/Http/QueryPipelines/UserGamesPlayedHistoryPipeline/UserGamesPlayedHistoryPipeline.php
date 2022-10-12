<?php

namespace App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters\Sort;
use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters\ByGameFilter;
use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters\FilterByDate;
use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters\FilterByRank;
use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters\FilterByGameMode;
use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters\FilterByMaxBaseEntranceFee;
use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters\FilterByMinBaseEntranceFee;

class UserGamesPlayedHistoryPipeline extends Pipeline
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
            new Sort(request: $this->request),
            new ByGameFilter(request: $this->request),
            new FilterByMaxBaseEntranceFee(request: $this->request),
            new FilterByMinBaseEntranceFee(request: $this->request),
            new FilterByGameMode(request: $this->request),
            new FilterByRank(request: $this->request),
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
