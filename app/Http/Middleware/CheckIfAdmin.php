<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfAdmin
{
    /**
     * @param [type] $user [description]
     *
     * @return bool [description]
     */
    private function checkIfUserIsAdmin($user)
    {
        return collect(['bugraergin@gmail.com', 'burakergin95@gmail.com'])->contains($user->email);
    }

    /**
     * Answer to unauthorized access request.
     *
     * @param [type] $request [description]
     *
     * @return [type] [description]
     */
    private function respondToUnauthorizedRequest($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(trans('backpack::base.unauthorized'), 401);
        } else {
            return redirect()->guest(backpack_url('login'));
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (backpack_auth()->guest()) {
            return $this->respondToUnauthorizedRequest($request);
        }

        if (! $this->checkIfUserIsAdmin(backpack_user())) {
            return $this->respondToUnauthorizedRequest($request);
        }
        return $next($request);
    }
}
