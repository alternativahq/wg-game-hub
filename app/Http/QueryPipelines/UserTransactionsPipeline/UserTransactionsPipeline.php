<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline;

use App\Http\QueryPipelines\UserAchievementsPipeline\Filters\ByGameFilter;
use App\Http\QueryPipelines\UserAchievementsPipeline\Filters\Sort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use App\Http\QueryPipelines\UserTransactionsPipeline\Filters\SortByTime;
use App\Http\QueryPipelines\UserTransactionsPipeline\Filters\SortByTxid;
use App\Http\QueryPipelines\UserTransactionsPipeline\Filters\SortByType;
use App\Http\QueryPipelines\UserTransactionsPipeline\Filters\SortByAsset;
use App\Http\QueryPipelines\UserTransactionsPipeline\Filters\SortByState;
use App\Http\QueryPipelines\UserTransactionsPipeline\Filters\SortByAmount;

class UserTransactionsPipeline extends Pipeline
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
            new SortByTime(request: $this->request),
            new SortByType(request: $this->request),
            new SortByAsset(request: $this->request),
            new SortByAmount(request: $this->request),
            new SortByTxid(request: $this->request),
            new SortByState(request: $this->request),
        ];
    }

    public static function make(Builder $builder, Request $request): Builder
    {
        return app(static::class)
            ->setRequest(request: $request)
            ->send(
                $builder->with([
                    'game' => function ($query) {
                        $query->select('id', 'name');
                    },
                    'achievement' => function ($query) {
                        $query->select('id', 'name', 'description');
                    },
                ]),
            )
            ->thenReturn();
    }
}
