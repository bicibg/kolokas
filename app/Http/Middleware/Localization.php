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
        $locale = null;
        $requestedLocale = null;
        if ($request->segment(1) && Arr::exists(Config::get('app.languages'), $request->segment(1))) {
            $locale = $requestedLocale = $request->segment(1);
        } else {
            if (auth()->check() && auth()->user()->locale) {
                $locale = auth()->user()->locale;
//            } elseif (
//                $request->cookie('kolokas_locale') &&
//                Arr::exists(Config::get('app.languages'), $request->cookie('kolokas_locale'))
//            ) {
//                $locale = $request->cookie('kolokas_locale');
            } elseif (
                Session::has('kolokas.locale') &&
                Arr::exists(Config::get('app.languages'), Session::get('kolokas.locale'))
            ) {
                $locale = Session::get('kolokas.locale');
            } elseif ($request->getPreferredLanguage(array_keys(Config::get('app.languages')))) {
                $locale = $request->getPreferredLanguage(array_keys(Config::get('app.languages')));
            }
        }

        if (!$locale || !Arr::exists(Config::get('app.languages'), $locale)) {
            $locale = Config::get('app.fallback_locale');
        }

        if (auth()->check()) {
            auth()->user()->locale = $locale;
            auth()->user()->save();
        }
        Session::put('kolokas.locale', $locale);
        app()->setLocale($locale);

//        if ($requestedLocale) {
//            return redirect()->back()->cookie('kolokas_locale', $locale, 4320);
//        }
//        return $next($request)->cookie('kolokas_locale', $locale, 4320);
        return $next($request);
    }
}
