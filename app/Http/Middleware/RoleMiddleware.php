<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user()?->role !== $role) {
            $dashboard = $request->user()?->role === 'admin'
                ? route('admin.dashboard')
                : route('guru.dashboard');

            return redirect($dashboard);
        }

        return $next($request);
    }
}
