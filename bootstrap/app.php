<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckCuratorStatus;
use App\Http\Middleware\CheckAccountStatus;
use App\Http\Middleware\GuestOrMember;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => CheckRole::class,
            'curator.active' => CheckCuratorStatus::class,
            'account.active' => CheckAccountStatus::class,
            'guest.or.member' => GuestOrMember::class,
        ]);

        $middleware->redirectGuestsTo('/dashboard');
        $middleware->redirectUsersTo('/dashboard');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
