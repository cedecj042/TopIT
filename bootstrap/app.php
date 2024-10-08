<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'student' => \App\Http\Middleware\StudentAccess::class,
            'admin' => \App\Http\Middleware\AdminAccess::class,
        ]);
        $middleware->validateCsrfTokens(except:[
            'admin/store-processed-pdf/',
            'admin/store-questions/',
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
