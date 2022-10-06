<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->status !== 1) {
            return response()->json(['success' => false, 'message' => 'Unauthorised.', 'data' => ['error' => 'Unauthorised']], 401);
        }

        return $next($request);
    }
}
