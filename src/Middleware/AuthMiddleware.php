<?php

namespace KhanCode\LaravelRestBuilder\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use KhanCode\LaravelRestBuilder\Models\Users;

class AuthMiddleware
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
        if (!Auth::guard('laravelrestbuilder_auth')->check()) {
            return redirect('/login');
        }

        return $next($request);
    }
}
