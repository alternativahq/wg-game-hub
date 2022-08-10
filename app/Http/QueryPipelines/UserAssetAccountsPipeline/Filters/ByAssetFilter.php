<?php

namespace App\Http\QueryPipelines\UserAssetAccountsPipeline\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ByAssetFilter
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Builder $builder, Closure $next)
    {
        $builder->when($this->request->get('filter_by_asset'), function (Builder $builder, $assetId) {
            $builder->where('user_asset_account.asset_id', $assetId);
        });

        return $next($builder);
    }
}
