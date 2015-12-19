<?php

namespace App\Http\Middleware;

use Config;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class BanHammer
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
        if (in_array(Config::get("banned.ipv4"), $request->ip()) {
            dd("Banned IP.");
        }
        
        return $next($request);
    }
}
