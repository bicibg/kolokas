<?php

namespace App\Http\Middleware;

use app;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uri = $request->segments();
        $availableLangs = array_keys(Config::get('app.languages'));

        app()->setLocale(app()->getLocale());
        $this->setAppLocaleIfPresentInUri($uri);

        $locale = null;

        $url_locale = request()->segment(1);

        if (in_array($url_locale, $availableLangs)) {
            $changeLocale = $url_locale;
        }

        if (!empty($changeLocale) && in_array($changeLocale, $availableLangs)) {
            $locale = $changeLocale;
            if (auth()->check()) {
                $this->updateUserLocale($locale);
            }
        } else {
            $localeCookie = $this->getLocaleCookie();
            if (!empty($localeCookie)) {
                $locale = $localeCookie;
            }
        }

        if (auth()->check() && $locale && auth()->user()->locale != $locale) {
            $locale = auth()->user()->locale;
        }

        if (!$locale) {
            $locale =  $request->getPreferredLanguage(array_keys(Config::get('app.languages')));
        }

        if (auth()->user() && is_null(auth()->user()->locale)) {
            $this->updateUserLocale($locale);
        }

        if ($this->getLocaleCookie() != $locale) {
            $this->setLocaleCookie($locale);
        }

        if (app()->getLocale() != $locale) {
            \App::setLocale($locale);
        }

        if (empty($uri[0])) {
            return redirect()->route('home', ['locale' => $locale]);
        }

        if (in_array($uri[0], $availableLangs)) {
            if ($locale && ($uri[0] != $locale)) {
                $uri[0] = $locale;
                $path = implode("/", $uri);
                if ($request->getQueryString()) {
                    $path = $path . "?" . $request->getQueryString();
                }

                return redirect()->to($path);
            } else {
                \App::setLocale($locale);
            }
        } else {
            $path = implode("/", $uri);

            return redirect()->to(url($locale . '/' . $path));
        }
        request()->route()->setParameter('locale', $locale);

        return $next($request);
    }

    /**
     * @param  array  $requestSegments
     */
    private function setAppLocaleIfPresentInUri(array $requestSegments)
    {
        $langs = ['en', 'tr', 'el'];
        if (isset($requestSegments[0]) && in_array($requestSegments[0], $langs)) {
            app()->setLocale($requestSegments[0]);
        }

        // check the key '3' has lang code if so, then set the locale
        if (isset($requestSegments[3]) && in_array($requestSegments[3], $langs)) {
            app()->setLocale($requestSegments[3]);
        }
    }

    /**
     * @param  string  $locale
     */
    private function updateUserLocale(string $locale)
    {
        auth()->user()->locale = $locale;
        auth()->user()->save();
    }

    /**
     * @return string
     */
    private function getLocaleCookie()
    {
        return Cookie::get('kolokas.locale', null);
    }

    /**
     * @param  string  $locale
     */
    private function setLocaleCookie(string $locale)
    {
        Cookie::queue(
            Cookie::make(
                'kolokas.locale',
                $locale,
                Carbon::now()->diffInMinutes(Carbon::now()->addWeeks(4))
            )
        );
    }

}
