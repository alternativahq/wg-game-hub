<?php

namespace App\Http\QueryPipelines\UserAssetAccountsPipeline;

use App\Http\QueryPipelines\UserAssetAccountsPipeline\Filters\SearchFilter;
use App\Http\QueryPipelines\UserAssetAccountsPipeline\Filters\SortByNameFilter;
use App\Http\QueryPipelines\UserAssetAccountsPipeline\Filters\SortBySymbolFilter;
use App\Http\QueryPipelines\UserAssetAccountsPipeline\Filters\SortByUserAssetBalance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;

class UserAssetAccountsPipeline extends Pipeline
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
            new SortByNameFilter($this->request),
            new SortBySymbolFilter($this->request),
            new SortByUserAssetBalance($this->request),
            new SearchFilter($this->request),
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
