<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Initialization;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Append the Initialization middleware to the 'web' group
        // This ensures it runs on every browser request
        $middleware->web(append: [
            Initialization::class,
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            // If you have custom L5.5 middleware aliases, add them here
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();