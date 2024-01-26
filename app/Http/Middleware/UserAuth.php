<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \App\Models\User
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $authLevel)
    { 
        // go to the request if the user's level matches or exceeds the auth level
        if(auth()->user()->level >= config('constants.auth_level')[$authLevel] ) {
            return $next($request);
        }

        // otherwise, return an error page
        return response('Insufficient Privs', 403);
    }
}