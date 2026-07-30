<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'checkin.session' => \App\Http\Middleware\CheckInSessionMiddleware::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/check-in',
            'check-in',
            'api/check-in/*',
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            return response()->json([
                'message' => 'لقد تجاوزت عدد المحاولات المسموح بها. يرجى المحاولة بعد دقيقة.',
                'data'    => null,
            ], 429);
        });
    })->create();
