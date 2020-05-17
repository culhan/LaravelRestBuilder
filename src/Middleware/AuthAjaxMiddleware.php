<?php

namespace KhanCode\LaravelRestBuilder\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use KhanCode\LaravelRestBuilder\Models\Users;
use KhanCode\LaravelRestBuilder\Exceptions\AuthenticationException;

class AuthAjaxMiddleware
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
        if (!session()->has('project')) {            
            throw new AuthenticationException('expired');
        }

        return $next($request);
    }
}
