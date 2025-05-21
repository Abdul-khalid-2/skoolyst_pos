<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
<<<<<<< HEAD

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
=======
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            $centralDomains = config('tenancy.central_domains');

            // Register central domain routes
            foreach ($centralDomains as $domain) {
                Route::middleware('web')
                    ->domain($domain)
                    ->group(base_path('routes/web.php'));
            }
            Route::middleware('web')->group(base_path('routes/tenant.php'));
        },
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
>>>>>>> 4087c472f0dfb0ce89c282d5665377c5a352a50a
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
