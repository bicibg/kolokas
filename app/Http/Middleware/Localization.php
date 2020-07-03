<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use app;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Localization
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
        if (Session::has('locale') && Arr::exists(Config::get('app.languages'), Session::get('locale'))) {
            app()->setLocale(Session::get('locale'));
        } else {
            app()->setLocale(Config::get('app.fallback_locale'));
        }
        return $next($request);
    }
}
