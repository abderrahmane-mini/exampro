<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Redirect if not authenticated
        if (!$request->user()) {
            return redirect('login');
        }

        // Redirect if user role not authorized
        if (!in_array($request->user()->user_type, $roles)) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        return $next($request); // Let the controller handle everything else (menus, data, etc.)
    }
}
