<?php

namespace App\Http\Middleware;

use app;
use Closure;
use Illuminate\Http\Request;

class RememberLocale
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
        if (auth()->check() && auth()->user()->locale !== \Illuminate\Support\Facades\App::getLocale()) {
            auth()->user()->locale = \Illuminate\Support\Facades\App::getLocale();
            auth()->user()->save();
        }

        return $next($request);
    }
}
