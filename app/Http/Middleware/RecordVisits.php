<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RecordVisits
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
        $recipe = $request->route('recipe');
        if (!empty($recipe)) {
            $recipe->visit();
        }

        return $next($request);
    }

}
