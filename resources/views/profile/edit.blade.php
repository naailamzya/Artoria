@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="relative py-20 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                    Edit Your <span class="gradient-text neon-text">Profile</span>
                </h1>
                <p class="text-gray-400">Customize your artist identity</p>
            </div>

            <!-- Form Card -->
            <div class="glass rounded-3xl p-8 animate-fade-in-up animation-delay-200">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Profile Picture --}}
                    <div class="flex flex-col items-center space-y-4 pb-6 border-b border-white/10">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/'.$user->profile_picture) }}"
                                 class="w-32 h-32 rounded-full object-cover ring-4 ring-artoria-500/50 shadow-lg shadow-artoria-500/20">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-artoria-500 to-pink-500 flex items-center justify-center text-white text-4xl font-bold ring-4 ring-artoria-500/50 shadow-lg shadow-artoria-500/20">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <div class="w-full">
                            <label class="block mb-2 text-sm font-semibold text-gray-200">Profile Picture</label>
                            <div class="relative">
                                <input type="file" 
                                       name="profile_picture" 
                                       id="profile_picture"
                                       accept="image/*"
                                       class="hidden">
                                <label for="profile_picture" 
                                       class="flex items-center justify-center w-full px-6 py-4 bg-zinc-900/80 border-2 border-dashed border-white/20 rounded-xl text-white hover:border-artoria-500 hover:bg-zinc-900 focus:outline-none transition-all cursor-pointer group">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-artoria-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-300 group-hover:text-white transition-colors">Choose a file or drag here</span>
                                </label>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Recommended: Square image, at least 200×200px (JPG, PNG, max 2MB)</p>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-200">Name</label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900"
                               placeholder="Your display name"
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-200">Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all hover:bg-zinc-900"
                               placeholder="your.email@example.com"
                               required>
                        @error('email')
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
                        <label class="block mb-2 text-sm font-semibold text-gray-200">Bio</label>
                        <textarea name="bio" 
                                  rows="4"
                                  class="w-full px-4 py-3 bg-zinc-900/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all resize-none hover:bg-zinc-900"
                                  placeholder="Tell us about yourself and your art... What inspires you? What's your creative journey?">{{ old('bio', $user->bio) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            <span id="bio-count">{{ strlen(old('bio', $user->bio ?? '')) }}</span>/500 characters
                        </p>
                        @error('bio')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-white/10">
                        <a href="{{ route('profile.show', $user->username ?? $user->id) }}" 
                           class="w-full sm:w-auto px-6 py-3 bg-zinc-800/50 hover:bg-zinc-800 text-gray-300 hover:text-white font-semibold rounded-xl transition-all duration-300 text-center border border-white/10">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-artoria-500 to-pink-500 hover:from-artoria-600 hover:to-pink-600 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-artoria-500/25 hover:shadow-artoria-500/40 hover:scale-105 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Background Effects -->
    <div class="absolute top-1/4 left-0 w-72 h-72 bg-artoria-500/10 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl animate-float animation-delay-200"></div>
</section>

@push('styles')
<style>
    .glass {
        background: rgba(17, 24, 39, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out forwards;
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Bio character counter
    const bioTextarea = document.querySelector('textarea[name="bio"]');
    const bioCount = document.getElementById('bio-count');
    
    if (bioTextarea && bioCount) {
        bioTextarea.addEventListener('input', function() {
            bioCount.textContent = this.value.length;
            
            if (this.value.length > 500) {
                bioCount.classList.add('text-red-400');
                bioCount.classList.remove('text-gray-500');
            } else {
                bioCount.classList.remove('text-red-400');
                bioCount.classList.add('text-gray-500');
            }
        });
    }

    // File input preview
    const fileInput = document.getElementById('profile_picture');
    const fileLabel = document.querySelector('label[for="profile_picture"] span');
    
    if (fileInput && fileLabel) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                fileLabel.textContent = fileName;
            } else {
                fileLabel.textContent = 'Choose a file or drag here';
            }
        });
    }
</script>
@endpush
@endsection