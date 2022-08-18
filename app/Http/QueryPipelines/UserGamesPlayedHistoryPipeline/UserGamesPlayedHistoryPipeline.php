<?php

namespace App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline;

use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters\ByGameFilter;
use App\Http\QueryPipelines\UserGamesPlayedHistoryPipeline\Filters\Sort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class UserGamesPlayedHistoryPipeline extends Pipeline
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
            new Sort(request: $this->request),
            new ByGameFilter(request: $this->request)
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
