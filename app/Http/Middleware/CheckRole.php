<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login')
                ->with('error', 'Please login to continue.');
        }

        // ✅ TAMBAHAN: Cek curator pending tidak bisa akses member routes
        if ($request->user()->role === 'curator' && $request->user()->status === 'pending') {
            // Jika curator pending coba akses member routes, redirect ke pending page
            if (in_array('member', $roles) || in_array('curator', $roles)) {
                return redirect()->route('curator.pending')
                    ->with('warning', 'Please wait for your curator application to be approved.');
            }
        }

        // Cek role
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized access. You do not have permission to access this resource.');
        }

        return $next($request);
    }
}