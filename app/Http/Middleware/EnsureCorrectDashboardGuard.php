<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCorrectDashboardGuard
{
    public function handle(Request $request, Closure $next, string $expectedGuard): Response
    {
        foreach (['admin', 'author'] as $guard) {
            if ($guard !== $expectedGuard && Auth::guard($guard)->check()) {
                abort(403);
            }
        }

        return $next($request);
    }
}

