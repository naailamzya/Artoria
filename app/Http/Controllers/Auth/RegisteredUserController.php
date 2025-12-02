<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'account_type' => ['required', 'in:member,curator'],
        ]);

        if ($request->account_type === 'curator') {
            $request->validate([
                'brand_name' => ['required', 'string', 'max:255'],
                'portfolio_url' => ['required', 'url', 'max:255'],
                'bio' => ['nullable', 'string', 'max:1000'],
                'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
            ]);
        }

        $status = $validated['account_type'] === 'curator' ? 'pending' : 'active';

        $profilePicturePath = null;
        if ($request->hasFile('logo')) {
            $profilePicturePath = $request->file('logo')->store('profile-pictures', 'public');
        }

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['account_type'],
            'status' => $status,
            'profile_picture' => $profilePicturePath,
            'bio' => $request->bio ?? null,
        ];

        if ($validated['account_type'] === 'curator') {
            $userData['brand_name'] = $request->brand_name;
            $userData['portfolio_url'] = $request->portfolio_url;
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'curator') {
            return redirect()->route('curator.pending')
                ->with('success', 'Curator application submitted! Please wait for admin approval.');
        }

        return redirect()->route('dashboard')
            ->with('success', 'Welcome to Artoria! Your account has been created.');
    }
}