<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCuratorStatus
{
    /**
     * Handle an incoming request.
     * Middleware ini untuk memastikan HANYA curator ACTIVE yang bisa akses
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Harus curator
        if ($user->role !== 'curator') {
            abort(403, 'Only curators can access this area.');
        }

        // Curator pending → redirect ke pending page
        if ($user->status === 'pending') {
            return redirect()->route('curator.pending')
                ->with('warning', 'Your curator account is pending approval.');
        }

        // Suspended → abort
        if ($user->status === 'suspended') {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your account has been suspended.');
        }

        // Only active curators pass
        return $next($request);
    }
}