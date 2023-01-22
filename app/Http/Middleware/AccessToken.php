<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AccessToken extends Middleware
{
    public function handle($request, Closure $next)
    {
        if ($request->input('access_token') !== env('ACCESS_TOKEN')) {
            return "";
        }

        return $next($request);
    }
}
