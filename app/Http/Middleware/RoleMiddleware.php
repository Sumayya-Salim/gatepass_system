<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user is logged in and their role matches
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // If role doesn't match, redirect to a 403 page or login
        return redirect('/forbidden');
    }
}