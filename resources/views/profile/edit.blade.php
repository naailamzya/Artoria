@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="relative py-20 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                    Edit Your <span class="gradient-text neon-text">Profile</span>
                </h1>
                <p class="text-gray-400">Customize your artist identity</p>
            </div>

            <!-- Form Card -->
            <div class="glass rounded-3xl p-8 md:p-12 animate-fade-in-up animation-delay-200">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Profile Picture --}}
                    <div class="flex flex-col items-center space-y-4 pb-6 border-b border-white/10">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/'.$user->profile_picture) }}"
                                 class="w-24 h-24 rounded-full object-cover ring-4 ring-artoria-500/30">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-artoria-500 to-pink-500 flex items-center justify-center text-white text-3xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <div class="w-full">
                            <label class="block mb-2 text-sm font-semibold text-gray-300">Profile Picture</label>
                            <input type="file" name="profile_picture" 
                                   class="w-full px-4 py-3 bg-zinc-900 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-artoria-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-artoria-500 file:text-white file:cursor-pointer hover:file:bg-artoria-600">
                            <p class="mt-2 text-xs text-gray-500">Recommended: Square image, at least 200x200px</p>
                        </div>
                    </div>

                    {{-- Name --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 bg-zinc-900 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 bg-zinc-900 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bio --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-300">Bio</label>
                        <textarea name="bio" rows="4"
                                  class="w-full px-4 py-3 bg--700 border border-zinc/10 rounded-xl text-black placeholder-black-900 focus:outline-none focus:ring-2 focus:ring-artoria-500 focus:border-transparent transition-all resize-none"
                                  placeholder="Tell us about yourself and your art...">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-zinc-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6">
                        <a href="{{ route('profile.show', $user->username ?? $user->id) }}" 
                           class="btn-secondary w-full sm:w-auto px-6 py-3 text-center">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary w-full sm:w-auto px-8 py-3">
                            Save Changes
                            <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
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

    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out forwards;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }

    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }
</style>
@endpush
@endsection