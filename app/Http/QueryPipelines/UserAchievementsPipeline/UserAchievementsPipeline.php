<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline;

use App\Http\QueryPipelines\UserAchievementsPipeline\Filters\SortByAchievementName;
use App\Http\QueryPipelines\UserAchievementsPipeline\Filters\SortByCreatedAt;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\UserAchievementsPipeline\Filters\Sort;
use App\Http\QueryPipelines\UserAchievementsPipeline\Filters\ByGameFilter;
use App\Http\QueryPipelines\UserAchievementsPipeline\Filters\SortByName;
use App\Http\QueryPipelines\UserAchievementsPipeline\Filters\SortByGameName;

class UserAchievementsPipeline extends Pipeline
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
            new SortByAchievementName(request: $this->request),
            new ByGameFilter(request: $this->request),
            new SortByCreatedAt(request: $this->request),
        ];
    }

    public static function make(Builder $builder, Request $request): Builder
    {
        return app(static::class)
            ->setRequest(request: $request)
            ->send($builder->with(['game:id,name']))
            ->thenReturn();
    }
}
