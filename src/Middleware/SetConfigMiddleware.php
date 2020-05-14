<?php

namespace KhanCode\LaravelRestBuilder\Middleware;

use Arr;
use Closure;
use Illuminate\Support\Facades\Auth;
use KhanCode\LaravelRestBuilder\Models\Users;

class SetConfigMiddleware
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
        config([
            'auth.guards.laravelrestbuilder_auth'   =>  [
                'driver' => 'session',
                'provider' => 'laravelrestbuilder_auth',
            ]
        ]); 

        config([
            'auth.providers.laravelrestbuilder_auth'   =>  [
                'driver' => 'eloquent',
                'model' => Users::class,
            ]
        ]);

        config([
            'laravelrestbuilder.project_id'   => Arr::get(session('project'),'id'),
            'laravelrestbuilder.copy_to'   => Arr::get(session('project'),'folder') 
        ]);

        return $next($request);
    }
}
