<?php

namespace App\Http\QueryPipelines\UserAchievementsPipeline;

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
            //TODO: need to add earned at sorting
            // new Sort(request: $this->request),
            new ByGameFilter(request: $this->request),
            new SortByGameName(request: $this->request),
            new SortByName(request: $this->request)
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
        // return app(static::class)
        //     ->setRequest(request: $request)
        //     ->send($builder)
        //     ->thenReturn();
    }
}
