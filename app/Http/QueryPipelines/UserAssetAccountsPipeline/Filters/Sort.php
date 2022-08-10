<?php

namespace App\Http\QueryPipelines\UserAssetAccountsPipeline\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use function PHPUnit\Framework\matches;

class Sort
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function allowedSortFields(): Collection
    {
        return collect([
            [
                'key' => 'assetAcount_name',
                'value' => 'assetAcount.name',
            ],
            // [
            //     'key' => 'assetAcount_balance',
            //     'value' => 'assetAcount.balance',
            // ],
            // [
            //     'key' => 'assetAcount_status',
            //     'value' => 'assetAcount.status',
            // ],
        ]);
    }

    public function handle(Builder $builder, Closure $next)
    {
        $sortBy = $this->request->get('sort_by');
        $sortOrder = $this->request->get('sort_order', 'asc');

        if (
            !in_array(
                $sortBy,
                $this->allowedSortFields()
                    ->values()
                    ->pluck('key')
                    ->toArray(),
            ) ||
            !in_array($sortOrder, ['asc', 'desc'])
        ) {
            return $next($builder);
        }

        $builder
            ->select('user_asset_account.*', 'asset.name as asset_name')
            ->join('assets', 'user_asset_account.asset_id', '=', 'asset.id')
            ->join('user_asset_account', 'user_asset_account.asset_id', '=', 'asset.id')
            ->orderBy(
                $this->allowedSortFields()
                    ->where('key', $sortBy)
                    ->value('value'),
                $sortOrder,
            );
        return $next($builder);
    }
}
