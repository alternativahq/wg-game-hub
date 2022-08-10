<?php

namespace App\Http\QueryPipelines\UserAssetAccountsPipeline;

use App\Http\QueryPipelines\UserAssetAccountsPipeline\Filters\ByAssetFilter;
use App\Http\QueryPipelines\UserAssetAccountsPipeline\Filters\Sort;
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

    protected function pipes()
    {
        return [new Sort(request: $this->request), new ByAssetFilter(request: $this->request)];
    }

    public static function make(Builder $builder, Request $request): Builder
    {
        return app(static::class)
            ->setRequest(request: $request)
            ->send(
                $builder->with([
                    'asset' => function ($query) {
                        $query->select('id', 'name','description','symbol');
                    },
                    'assetAccounts' => function ($query) {
                        $query->select('id', 'balance', 'status');
                    },
                ]),
            )
            ->thenReturn();
    }
}
