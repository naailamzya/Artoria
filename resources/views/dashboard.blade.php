@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="relative py-20 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            
            <!-- Welcome Header -->
            <div class="text-center mb-12 animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-4">
                    Welcome back, <span class="gradient-text neon-text">{{ auth()->user()->name }}</span>! 🎨
                </h1>
                <p class="text-gray-400 text-lg">Here's what's happening with your art</p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-fade-in-up animation-delay-200">
                <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl mb-2">🎨</div>
                    <div class="font-bold text-3xl gradient-text">{{ auth()->user()->artworks()->count() }}</div>
                    <div class="text-gray-400 text-sm mt-1">Artworks</div>
                </div>
                <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl mb-2">❤️</div>
                    <div class="font-bold text-3xl gradient-text">{{ auth()->user()->artworks()->sum('likes_count') }}</div>
                    <div class="text-gray-400 text-sm mt-1">Total Likes</div>
                </div>
                <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl mb-2">👁️</div>
                    <div class="font-bold text-3xl gradient-text">{{ auth()->user()->artworks()->sum('views_count') }}</div>
                    <div class="text-gray-400 text-sm mt-1">Total Views</div>
                </div>
                <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl mb-2">⭐</div>
                    <div class="font-bold text-3xl gradient-text">{{ auth()->user()->favorites()->count() }}</div>
                    <div class="text-gray-400 text-sm mt-1">Favorites</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass rounded-3xl p-8 mb-8 animate-fade-in-up animation-delay-400">
                <h2 class="text-2xl font-display font-bold text-white mb-6 flex items-center space-x-2">
                    <svg class="w-6 h-6 text-artoria-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Quick Actions</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('artworks.create') }}" 
                       class="p-6 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300 group">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full bg-artoria-500/20 flex items-center justify-center group-hover:bg-artoria-500/30 transition-all">
                                <svg class="w-6 h-6 text-artoria-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white">Upload Artwork</div>
                                <div class="text-sm text-gray-400">Share your creation</div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('profile.show', auth()->user()) }}" 
                       class="p-6 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300 group">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full bg-pink-500/20 flex items-center justify-center group-hover:bg-pink-500/30 transition-all">
                                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white">View Profile</div>
                                <div class="text-sm text-gray-400">Check your portfolio</div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('challenges.index') }}" 
                       class="p-6 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300 group">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center group-hover:bg-purple-500/30 transition-all">
                                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white">Join Challenge</div>
                                <div class="text-sm text-gray-400">Compete & win prizes</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            <div class="glass rounded-2xl p-6 text-center animate-fade-in-up animation-delay-600">
                <div class="text-6xl mb-4">🎉</div>
                <p class="text-xl text-white font-semibold mb-2">You're logged in!</p>
                <p class="text-gray-400">Start creating and sharing your amazing artworks</p>
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
        background: rgba(17, 24, 39, 0.5);
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

    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }

    .animation-delay-600 {
        animation-delay: 0.6s;
        opacity: 0;
    }
</style>
@endpush
@endsection