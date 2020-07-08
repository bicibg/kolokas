<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class CheckForDemoMode
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
        $route = Route::getRoutes()->match($request);
        $currentroute = $route->getName();

        if (config('demo.demo_enabled') && !Cookie::has('demo-activated')) {
            if (in_array($currentroute, config('demo.demo_route_names'))) {
                return $next($request);
            }
            return redirect(RouteServiceProvider::DEMO);
        } else if (config('demo.demo_enabled') && Cookie::has('demo-activated')){
            if (in_array($currentroute, config('demo.demo_route_names'))) {
                return redirect(RouteServiceProvider::HOME);
            }
            return $next($request);
        } else {
            return $next($request);
        }
    }
}
