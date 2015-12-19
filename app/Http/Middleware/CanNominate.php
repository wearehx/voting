<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CanNominate
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
        if (canNominate()) {
            return $next($request);
        }

        return redirect("/");
    }
}
