<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:member,curator'],
            
            // Curator fields (required only if role is curator)
            'brand_name' => ['required_if:role,curator', 'string', 'max:255'],
            'brand_description' => ['required_if:role,curator', 'string', 'max:1000'],
            'website' => ['nullable', 'url', 'max:255'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
        ]);

        // Tentukan status berdasarkan role
        $status = $request->role === 'curator' ? 'pending' : 'active';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $status,
            
            // Curator specific fields
            'brand_name' => $request->brand_name,
            'brand_description' => $request->brand_description,
            'website' => $request->website,
            'portfolio_url' => $request->portfolio_url,
        ]);

        event(new Registered($user));

        // Login user (baik member maupun curator)
        Auth::login($user);

        // Redirect berdasarkan role
        if ($user->role === 'curator' && $user->status === 'pending') {
            // Curator pending → pending page
            return redirect()->route('curator.pending');
        }

        // Member atau curator active → dashboard
        return redirect()->route('dashboard');
    }
}