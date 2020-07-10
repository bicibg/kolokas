<?php

namespace App\Http\Middleware;

use app;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        if (auth()->check() && auth()->user()->locale) {
            $locale = auth()->user()->locale;
        } elseif (
            Session::has('kolokas.locale') &&
            Config::get('app.languages')[Session::get('kolokas.locale')]
        ) {
            $locale = Session::get('kolokas.locale');
        } elseif ($request->getPreferredLanguage(array_keys(Config::get('app.languages')))) {
            $locale = $request->getPreferredLanguage(array_keys(Config::get('app.languages')));
        } else {
            $locale = Config::get('app.fallback_locale');
        }

        if (!Arr::exists(Config::get('app.languages'), $locale)) {
            $locale = Config::get('app.fallback_locale');
        }

        if (auth()->check()) {
            auth()->user()->locale = $locale;
            auth()->user()->save();
        }
        Session::put('kolokas.locale', $locale);
        app()->setLocale($locale);
        return $next($request);
    }
}
