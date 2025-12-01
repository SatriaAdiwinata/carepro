<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\PreventBackHistory;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registering Global Middleware
        $middleware->web(PreventBackHistory::class);

        // DAFTAR ALIAS MIDDLEWARE KUSTOM
        $middleware->alias([
            // Alias yang sudah ada
            'admin' => \App\Http\Middleware\CheckAdminRole::class, 
            
            // TAMBAHAN BARIS UNTUK MEMPERBAIKI ERROR 'peran'
            'peran' => \App\Http\Middleware\Peran::class, 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();