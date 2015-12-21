<?php

namespace App\Http\Middleware;

use Closure;

class CanVoteOrNominate
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
        if (canVote(false) || canNominate(false)) {
            return $next($request);
        }

        return redirect('/');
    }
}
