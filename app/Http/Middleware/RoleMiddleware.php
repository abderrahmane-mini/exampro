<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect('login');
        }

        if (!in_array($request->user()->user_type, $roles)) {
            abort(403, 'Unauthorized access');
        }

        // Dynamically set menu based on user role
        $menuMethod = 'getMenu' . ucfirst($request->user()->user_type);
        if (method_exists($this, $menuMethod)) {
            $request->merge(['dynamic_menu' => $this->$menuMethod()]);
        }

        return $next($request);
    }
}