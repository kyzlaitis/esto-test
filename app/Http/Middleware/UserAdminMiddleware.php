<?php

namespace App\Http\Middleware;

use Closure;

class UserAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->user()->permission) {
            return response()->json(['Unauthorized action'], 401);
        }
        return $next($request);
    }
}
