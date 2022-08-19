<?php

namespace App\Http\QueryPipelines\UserDepositsPipeline\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SortByAmount
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Builder $builder, Closure $next)
    {
        $sortBy = $this->request->get('sort_by');
        $sortOrder = $this->request->get('sort_order', 'asc');

        if ($sortBy !== 'transaction_amount') {
            return $next($builder);
        }

        if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
            return $next($builder);
        }
        $builder->orderBy('transactions.amount', $sortOrder);

        return $next($builder);
    }
}
