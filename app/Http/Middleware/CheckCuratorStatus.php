<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCuratorStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role !== 'curator') {
            abort(403, 'Only curators can access this area.');
        }

        if ($user->status === 'pending') {
            return redirect()->route('curator.pending')
                ->with('warning', 'Your curator account is pending approval.');
        }

        if ($user->status === 'suspended') {
            abort(403, 'Your account has been suspended.');
        }

        return $next($request);
    }
}