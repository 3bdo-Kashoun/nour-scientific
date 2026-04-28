<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {


        $middleware->encryptCookies(except: [
            'remember_email',
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
       $exceptions->render(function (QueryException $e, Request $request) {
        // نتحقق من كود الخطأ 2002 (المعروف بـ Connection Refused)
        if ($e->getCode() === 2002 || str_contains($e->getMessage(), 'Connection refused')) {
            return response()->view('errors.database', [], 500);
        }
    });
    })->create();
