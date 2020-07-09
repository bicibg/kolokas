<?php

namespace App\Http\Middleware;

use app;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (
            Session::has('kolokas.locale') &&
            Config::get('app.languages')[Session::get('kolokas.locale')]
        ) {
            $locale = Session::get('kolokas.locale');
        } elseif ($request->server('HTTP_ACCEPT_LANGUAGE')) {
            $locale = explode('-', $request->server('HTTP_ACCEPT_LANGUAGE'))[0];
        } else {
            $locale = Config::get('app.fallback_locale');
        }
        app()->setLocale($locale);
        return $next($request);
    }
}
