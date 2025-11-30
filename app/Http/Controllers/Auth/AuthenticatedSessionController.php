<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate user (suspended sudah di-handle di LoginRequest)
        $request->authenticate();

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        // Get authenticated user
        $user = Auth::user();
        
        // 🔥 REDIRECT LOGIC BERDASARKAN ROLE & STATUS
        
        // 1. ADMIN → Admin Dashboard
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // 2. CURATOR PENDING → Curator Pending Page (TIDAK BOLEH AKSES DASHBOARD)
        if ($user->role === 'curator' && $user->status === 'pending') {
            return redirect()->route('curator.pending', absolute: false)
                ->with('warning', 'Your curator application is still under review. You will be notified once approved.');
        }

        // 3. CURATOR REJECTED → Member Dashboard (downgrade otomatis)
        if ($user->role === 'curator' && $user->status === 'rejected') {
            return redirect()->route('dashboard', absolute: false)
                ->with('error', 'Your curator application was rejected. You can reapply after improving your portfolio.');
        }

        // 4. CURATOR ACTIVE → Curator Dashboard
        if ($user->role === 'curator' && $user->status === 'active') {
            return redirect()->intended(route('curator.dashboard', absolute: false));
        }

        // 5. MEMBER atau fallback → Member Dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}