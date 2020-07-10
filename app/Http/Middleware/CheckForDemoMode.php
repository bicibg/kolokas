<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class CheckForDemoMode
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $route = Route::getRoutes()->match($request);
        $currentroute = $route->getName();

        $response = $next($request);

        if (config('demo.demo_enabled') && !Cookie::get('demo-activated')) {
            if (in_array($currentroute, config('demo.demo_route_names'))) {
                return $response;
            }
            return redirect(RouteServiceProvider::DEMO);
        } elseif (config('demo.demo_enabled') && Cookie::has('demo-activated')) {
            if (in_array($currentroute, config('demo.demo_route_names'))) {
                return redirect(RouteServiceProvider::HOME);
            }
            return $response;
        } else {
            return $response;
        }
    }
}
