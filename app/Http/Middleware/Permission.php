<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        dd(Auth::guard($guard)->user()->positionID);
        if (Auth::guard($guard)->user()->positionID != 1) {
            return redirect('/');
        }
        return $next($request);
    }
}
