<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AWSMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (
            is_null($header = $request->header('Authorization', null))
        ) {
            return abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized.');
        }
        // // dd($request->header('Authorization', null));
        // // $obj = { "email": "yaman.jamal@alternativa.dev","sub": "bd5720a7-4482-4a84-97e2-f7b973f3a475"}
        // $tokenObj = json_decode($header, false);
        // // dd($tokenObj);
        // $request->headers->set('Authorization', $tokenObj);
        // // dd($request->header('Authorization', null));
        return $next($request);
    }
}
