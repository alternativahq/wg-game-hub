<?php

namespace App\Http\QueryPipelines\UserWithdrawalsPipeline;

use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use App\Http\QueryPipelines\UserWithdrawalsPipeline\Filters\SortByState;
use App\Http\QueryPipelines\UserWithdrawalsPipeline\Filters\SortByAmount;

class UserDepositsPipeline extends Pipeline
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
            new SortByAmount(request: $this->request),
            new SortByState(request: $this->request),
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
