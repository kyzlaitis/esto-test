<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->permission) {
            return response()->json(['Unauthorized action'], 401);
        }

        return $next($request);
    }
}
