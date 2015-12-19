<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Nomination;

class CanRun
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
        if (Auth::user()->canRun()) {
            return $next($request);
        }

        return redirect("/");
    }
}
