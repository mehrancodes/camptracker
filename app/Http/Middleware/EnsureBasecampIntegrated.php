<?php

namespace App\Http\Middleware;

use Closure;

class EnsureBasecampIntegrated
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
        if (! $request->user()->has_basecamp_connected) {
            return redirect()->route('basecamp.connect');
        }

        return $next($request);
    }
}
