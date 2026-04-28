<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Handle an unauthenticated user for the requested guard(s).
     * If the user is authenticated under the other dashboard guard,
     * treat it as forbidden access (403), not as a guest redirect.
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards): void
    {
        $dashboardGuards = ['admin', 'author'];

        foreach ($guards as $expectedGuard) {
            if (!in_array($expectedGuard, $dashboardGuards, true)) {
                continue;
            }

            foreach ($dashboardGuards as $guard) {
                if ($guard !== $expectedGuard && Auth::guard($guard)->check()) {
                    abort(403);
                }
            }
        }

        throw new AuthenticationException(
            'Unauthenticated.',
            $guards,
            $this->redirectTo($request),
        );
    }

    /**
     * Redirect guests to the shared login page.
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return route('login');
        }

        return null;
    }
}

