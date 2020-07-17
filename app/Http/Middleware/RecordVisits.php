<?php

namespace App\Http\Middleware;

use App\Models\Visit;
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
        } else {
            $visit = [
                'session_id' => request()->getSession()->getId(),
                'ip' => request()->getClientIp(),
                'agent' => request()->header('User-Agent'),
                'user_id' => auth()->id(),
            ];
            $existingSessionVisits = Visit::where('session_id', request()->getSession()->getId())
                ->whereNull('visited_type')
                ->whereNull('visited_id')->count();
            if (!$existingSessionVisits)
            {
                Visit::create($visit);
            }
        }

        return $next($request);
    }

}
