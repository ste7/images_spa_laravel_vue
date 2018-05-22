<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! (new User())->user()) {
            return redirect()->back();
        }

        return $next($request);
    }
}
