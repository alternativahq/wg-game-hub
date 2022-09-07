<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BasicTokenAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (
            is_null($header = $request->header('Authorization', null)) ||
            $header !== config('wodo.api-authorization-token')
        ) {
            return abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized.');
        }
        return $next($request);
    }
}
