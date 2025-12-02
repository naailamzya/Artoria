<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        Log::info('CheckRole middleware triggered', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'required_roles' => $roles,
            'current_url' => $request->fullUrl(),
        ]);
        
        if (!in_array($user->role, $roles)) {
            Log::warning('Role check failed', [
                'user_role' => $user->role,
                'required' => $roles,
            ]);
            abort(403, 'You do not have the required role to access this page.');
        }
        
        return $next($request);
    }
}