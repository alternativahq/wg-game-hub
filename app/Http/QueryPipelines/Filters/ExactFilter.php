<?php

namespace App\Http\QueryPipelines\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class ExactFilter extends Filter
{
    public function handle(Builder $builder, Closure $next): mixed
    {
        $builder->when($this->request->get($this->getParam()), function (Builder $query, $value) {
            $query->where($this->column, '=', $value);
        });
        return $next($builder);
    }
}
