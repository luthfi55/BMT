<?php

namespace App\Http\Middleware;

use Closure;

class HandleMissingToken
{
    public function handle($request, Closure $next)
    {
        if (!$request->bearerToken()) {
            return response()->json([
                'error' => 'Unauthenticated. Token not provided.',
            ], 401);
        }

        return $next($request);
    }
}
