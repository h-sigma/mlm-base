<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsAdmin
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
        $user = Auth::user();
        if(!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        } elseif (!$user->admin) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }
        return $next($request);
    }
}
