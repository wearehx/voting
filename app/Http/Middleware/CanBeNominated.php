<?php

namespace App\Http\Middleware;

use Closure;

class CanBeNominated
{
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
        if (canNominate(false)) {
            return $next($request);
        }

        return redirect('/');
    }
}
