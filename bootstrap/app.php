<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Initialization;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Trust all proxies (Load Balancers) and use standard headers
        $middleware->trustProxies(at: '*', headers: 
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB
        );

        // Run your custom template parsing middleware on all web requests
        $middleware->web(append: [
            Initialization::class,
        ]);

        // Disable CSRF across the board
        $middleware->validateCsrfTokens(except: [
            '*',
        ]);

        // Register custom legacy aliases
        $middleware->alias([
            'public.api.auth' => \App\Http\Middleware\PublicAPIAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();