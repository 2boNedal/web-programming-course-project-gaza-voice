<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EnsureCorrectDashboardGuard;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => Authenticate::class,
            'dashboard.guard' => EnsureCorrectDashboardGuard::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $isJsonRequest = static function (Request $request): bool {
            return $request->expectsJson() || $request->wantsJson() || $request->is('tags/suggest');
        };

        $exceptions->render(function (AuthenticationException $exception, Request $request) use ($isJsonRequest) {
            if ($isJsonRequest($request)) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                ], 401);
            }
        });

        $exceptions->render(function (AuthorizationException $exception, Request $request) use ($isJsonRequest) {
            if ($isJsonRequest($request)) {
                return response()->json([
                    'message' => 'Forbidden.',
                ], 403);
            }
        });

        $exceptions->render(function (ValidationException $exception, Request $request) use ($isJsonRequest) {
            if ($isJsonRequest($request)) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $exception->errors(),
                ], 422);
            }
        });

        $exceptions->render(function (ModelNotFoundException $exception, Request $request) use ($isJsonRequest) {
            if ($isJsonRequest($request)) {
                return response()->json([
                    'message' => 'Not found.',
                ], 404);
            }
        });

        $exceptions->render(function (HttpException $exception, Request $request) use ($isJsonRequest) {
            if ($isJsonRequest($request) && in_array($exception->getStatusCode(), [401, 403, 404, 409], true)) {
                return response()->json([
                    'message' => $exception->getMessage() !== '' ? $exception->getMessage() : match ($exception->getStatusCode()) {
                        401 => 'Unauthenticated.',
                        403 => 'Forbidden.',
                        404 => 'Not found.',
                        409 => 'Conflict.',
                    },
                ], $exception->getStatusCode());
            }
        });
    })->create();
