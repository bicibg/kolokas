<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfAdmin
{
    private function isAdmin(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return in_array($user->email, [
            'bugraergin@gmail.com',
            'burakergin95@gmail.com',
        ]);
    }

    public function handle(Request $request, Closure $next)
    {
        if (! $this->isAdmin()) {
            return redirect('/');
        }

        return $next($request);
    }
}
