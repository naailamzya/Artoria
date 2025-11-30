<x-guest-layout>
    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">
            Join <span class="gradient-text">Artoria</span>
        </h1>
        <p class="text-gray-400 text-sm">Create your account and start sharing your art</p>
    </div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5" 
          x-data="{ accountType: 'member', showCuratorFields: false }">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block mb-2 text-sm font-semibold text-gray-200">Name</label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}"
                   class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900"
                   placeholder="Your display name"
                   required 
                   autofocus 
                   autocomplete="name">
            @error('name')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

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

        {{-- Account Type Selection --}}
        <div>
            <label class="block mb-3 text-sm font-semibold text-gray-200">Account Type</label>
            <div class="grid grid-cols-2 gap-4">
                {{-- Member Option --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" 
                           name="account_type" 
                           value="member" 
                           x-model="accountType"
                           @change="showCuratorFields = false"
                           checked
                           class="peer sr-only">
                    <div class="glass rounded-xl p-4 border-2 border-white/10 peer-checked:border-artoria-500 peer-checked:bg-artoria-500/10 transition-all duration-300 hover:border-white/20">
                        <div class="flex flex-col items-center text-center space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Member</p>
                                <p class="text-xs text-gray-400">Share your art</p>
                            </div>
                        </div>
                    </div>
                </label>

                {{-- Curator Option --}}
                <label class="relative cursor-pointer group">
                    <input type="radio" 
                           name="account_type" 
                           value="curator" 
                           x-model="accountType"
                           @change="showCuratorFields = true"
                           class="peer sr-only">
                    <div class="glass rounded-xl p-4 border-2 border-white/10 peer-checked:border-artoria-500 peer-checked:bg-artoria-500/10 transition-all duration-300 hover:border-white/20">
                        <div class="flex flex-col items-center text-center space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-artoria-500 to-pink-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Curator</p>
                                <p class="text-xs text-gray-400">Brand/Studio</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            @error('account_type')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Curator Additional Fields --}}
        <div x-show="showCuratorFields" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             class="space-y-4 p-4 glass rounded-xl border border-artoria-500/30"
             style="display: none;">
            
            <div class="flex items-center space-x-2 mb-3">
                <svg class="w-5 h-5 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-gray-300 font-semibold">Curator Information</p>
            </div>

            {{-- Brand/Studio Name --}}
            <div>
                <label for="brand_name" class="block mb-2 text-sm font-semibold text-gray-200">
                    Brand/Studio Name <span class="text-red-400">*</span>
                </label>
                <input id="brand_name" 
                       type="text" 
                       name="brand_name" 
                       value="{{ old('brand_name') }}"
                       class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900"
                       placeholder="e.g., Studio Artoria, Brand X"
                       x-bind:required="accountType === 'curator'">
                @error('brand_name')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Logo Upload --}}
            <div>
                <label for="logo" class="block mb-2 text-sm font-semibold text-gray-200">
                    Brand Logo <span class="text-gray-400 text-xs">(Optional)</span>
                </label>
                <input id="logo" 
                       type="file" 
                       name="logo" 
                       accept="image/*"
                       class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-artoria-500 file:text-white hover:file:bg-artoria-600 file:cursor-pointer transition-all">
                <p class="mt-1 text-xs text-gray-400">PNG, JPG, or SVG. Max 2MB.</p>
                @error('logo')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Portfolio URL --}}
            <div>
                <label for="portfolio_url" class="block mb-2 text-sm font-semibold text-gray-200">
                    Portfolio URL <span class="text-red-400">*</span>
                </label>
                <input id="portfolio_url" 
                       type="url" 
                       name="portfolio_url" 
                       value="{{ old('portfolio_url') }}"
                       class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900"
                       placeholder="https://yourportfolio.com"
                       x-bind:required="accountType === 'curator'">
                <p class="mt-1 text-xs text-gray-400">Link to your brand website or portfolio</p>
                @error('portfolio_url')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Bio --}}
            <div>
                <label for="bio" class="block mb-2 text-sm font-semibold text-gray-200">
                    Bio <span class="text-gray-400 text-xs">(Optional)</span>
                </label>
                <textarea id="bio" 
                          name="bio" 
                          rows="3"
                          class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900 resize-none"
                          placeholder="Tell us about your brand or studio...">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="mt-2 text-sm text-red-400 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Info Notice --}}
            <div class="flex items-start space-x-2 p-3 bg-yellow-500/10 border border-yellow-500/30 rounded-lg">
                <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-xs text-yellow-200">
                    Your curator account will be <strong>pending approval</strong> until an admin reviews your application. You'll receive an email once approved.
                </p>
            </div>
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block mb-2 text-sm font-semibold text-gray-200">Password</label>
            <input id="password" 
                   type="password" 
                   name="password"
                   class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900"
                   placeholder="Create a strong password"
                   required 
                   autocomplete="new-password">
            @error('password')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block mb-2 text-sm font-semibold text-gray-200">Confirm Password</label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation"
                   class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900"
                   placeholder="Confirm your password"
                   required 
                   autocomplete="new-password">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button type="submit" 
                class="w-full px-6 py-3 bg-gradient-to-r from-artoria-500 to-pink-500 hover:from-artoria-600 hover:to-pink-600 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-artoria-500/25 hover:shadow-artoria-500/40 hover:scale-[1.02] flex items-center justify-center mt-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Create Account
        </button>

        {{-- Login Link --}}
        <div class="text-center pt-4 border-t border-white/10">
            <p class="text-gray-400 text-sm">
                Already have an account? 
                <a href="{{ route('login') }}" 
                   class="text-artoria-400 hover:text-artoria-300 font-semibold transition-colors">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>