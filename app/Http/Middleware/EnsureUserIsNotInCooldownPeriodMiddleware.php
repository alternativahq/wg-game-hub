<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureUserIsNotInCooldownPeriodMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->isInCooldownPeriod) {
            $request->user()->resetCooldown();
            return $next($request);
        }

        if ($request->acceptsJson()) {
            return response()->json(
                [
                    'message' => 'You are in cooldown period',
                    'cooldown_end_at' => $request->user()->cooldown_end_at,
                ],
                Response::HTTP_FORBIDDEN,
            );
        }

        return redirect()->route('landing');
    }
}
