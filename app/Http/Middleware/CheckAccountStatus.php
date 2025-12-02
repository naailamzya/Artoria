<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
{
    \Log::info('CheckAccountStatus middleware called', [
        'url' => $request->fullUrl(),
        'user_id' => $request->user()?->id,
        'user_role' => $request->user()?->role,
        'user_status' => $request->user()?->status,
    ]);
    
}
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->status === 'suspended') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')
                ->with('error', 'Your account has been suspended.');
        }

        if ($user->role === 'admin') {
            return $next($request);
        }

        if ($user->status === 'active') {
            return $next($request);
        }

        if ($user->role === 'curator' && $user->status === 'pending') {
            
            if ($request->routeIs('curator.pending')) {
                return $next($request);
            }

            return redirect()->route('curator.pending')
                ->with('warning', 'Please wait for curator approval to gain full access.');
        }

        return redirect()->route('dashboard')
            ->with('error', 'Your account is not fully active or authorized for this action.');
    }
}