<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CanVote
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
        if (canVote()) {
            return $next($request);
        }

        return redirect("/");
    }
}
