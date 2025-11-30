<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestOrMember
{
    /**
     * Handle an incoming request.
     * Allow guest OR authenticated member to access
     */
    public function handle(Request $request, Closure $next): Response
    {
        // No restriction, anyone can access
        return $next($request);
    }
}