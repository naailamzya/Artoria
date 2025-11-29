<div class="glass rounded-3xl p-8 animate-fade-in-up animation-delay-200">
    <header class="mb-6">
        <h2 class="text-2xl font-display font-bold text-white mb-3 flex items-center space-x-2">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span>{{ __('Delete Account') }}</span>
        </h2>

        <p class="text-gray-400 text-sm leading-relaxed mb-6">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Delete Form (Always Visible) -->
    <div x-data="{ showConfirm: false }">
        <!-- Initial Button -->
        <div x-show="!showConfirm">
            <button
                type="button"
                x-on:click="showConfirm = true"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all duration-300 flex items-center space-x-2 shadow-lg hover:shadow-red-500/30"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>{{ __('Delete Account') }}</span>
            </button>
        </div>

        <!-- Confirmation Form (Shows when button clicked) -->
        <div x-show="showConfirm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             class="bg-dark-800 border-2 border-red-500/30 rounded-2xl p-8"
             style="display: none;">
            
            <div class="flex items-start space-x-4 mb-6">
                <div class="flex-shrink-0 w-16 h-16 rounded-full bg-red-500/20 flex items-center justify-center ring-4 ring-red-500/20">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-grow">
                    <h3 class="text-2xl font-bold text-white mb-2">
                        {{ __('Are you absolutely sure?') }}
                    </h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        {{ __('This action cannot be undone. This will permanently delete your account and remove all of your data from our servers. Please enter your password to confirm.') }}
                    </p>
                </div>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                @csrf
                @method('delete')

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-300 mb-3">
                        {{ __('Password') }}
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full px-4 py-4 bg-dark-700 border-2 border-white/10 rounded-xl text-white text-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                        placeholder="{{ __('Enter your password to confirm') }}"
                        required
                        autofocus
                    />

                    @if($errors->userDeletion->has('password'))
                        <p class="mt-3 text-sm text-red-400 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $errors->userDeletion->first('password') }}</span>
                        </p>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-4">
                    <button 
                        type="button"
                        x-on:click="showConfirm = false" 
                        class="w-full sm:w-auto px-8 py-4 bg-dark-700 hover:bg-dark-600 border border-white/10 text-white rounded-xl font-semibold transition-all text-lg">
                        {{ __('Cancel') }}
                    </button>

                    <button 
                        type="submit" 
                        class="w-full sm:w-auto px-8 py-4 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-red-500/30 text-lg flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>{{ __('Yes, Delete My Account') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>