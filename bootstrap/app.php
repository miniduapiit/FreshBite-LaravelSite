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
        // Register role-based access control middleware
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'sanitize' => \App\Http\Middleware\SanitizeInput::class,
            'validate.api' => \App\Http\Middleware\ValidateApiRequest::class,
        ]);
        
        // Apply rate limiting to API routes
        $middleware->api(prepend: [
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':60,1', // 60 requests per minute
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
