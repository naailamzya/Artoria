<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCuratorStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role !== 'curator') {
            abort(403, 'Only curators can access this area.');
        }

        if ($user->status !== 'active') {
            return redirect()->route('curator.pending')
                ->with('warning', 'Your curator account is not active yet.');
        }

        return $next($request);
    }
}