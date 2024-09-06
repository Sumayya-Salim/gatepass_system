<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.index'); // If not logged in, redirect to login
        }

        $userRole = Auth::user()->role; // Get user role from Auth

        // Check if user role is in the allowed roles
        if (!in_array($userRole, $roles)) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.'); // Redirect to dashboard
        }
        

        return $next($request);
    }
}
