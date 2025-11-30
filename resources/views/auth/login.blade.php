<x-guest-layout>
    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">
            Welcome <span class="gradient-text">Back</span>
        </h1>
        <p class="text-gray-400 text-sm">Sign in to continue your creative journey</p>
    </div>

    {{-- Session Status --}}
    @if(session('status'))
        <div class="mb-4 p-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email Address --}}
        <div>
            <label for="email" class="block mb-2 text-sm font-semibold text-gray-200">Email</label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900"
                   placeholder="your.email@example.com"
                   required 
                   autofocus 
                   autocomplete="username">
            @error('email')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block mb-2 text-sm font-semibold text-gray-200">Password</label>
            <div class="relative">
                <input id="password" 
                       type="password" 
                       name="password"
                       class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900"
                       placeholder="Enter your password"
                       required 
                       autocomplete="current-password">
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" 
                       type="checkbox" 
                       class="w-4 h-4 rounded border-white/20 bg-zinc-900 text-artoria-500 focus:ring-2 focus:ring-artoria-500 focus:ring-offset-0 transition-all cursor-pointer" 
                       name="remember">
                <span class="ml-2 text-sm text-gray-400 group-hover:text-gray-300 transition-colors">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-sm text-artoria-400 hover:text-artoria-300 transition-colors">
                    Forgot password?
                </a>
            @endif
        </div>

        {{-- Submit Button --}}
        <button type="submit" 
                class="w-full px-6 py-3 bg-gradient-to-r from-artoria-500 to-pink-500 hover:from-artoria-600 hover:to-pink-600 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-artoria-500/25 hover:shadow-artoria-500/40 hover:scale-[1.02] flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Sign In
        </button>

        {{-- Register Link --}}
        <div class="text-center pt-4 border-t border-white/10">
            <p class="text-gray-400 text-sm">
                Don't have an account? 
                <a href="{{ route('register') }}" 
                   class="text-artoria-400 hover:text-artoria-300 font-semibold transition-colors">
                    Sign up now
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>