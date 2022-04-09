<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->header('Accept') == 'application/json' || request()->routeIs('excute.pay') || request()->routeIs('pay.success') || request()->routeIs('pay.error')) {
            abort(createResponse(401, "Unauthenticated", (object)["credintials" => ["Unauthenticated"]], (object)[]));
        }else {
            if (! $request->expectsJson()) {
                return route('login');
            }
        }
    }
}
