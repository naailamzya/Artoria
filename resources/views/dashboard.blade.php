@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="relative py-20 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            
            <div class="text-center mb-16 animate-fade-in-up">
                <h1 class="text-4xl md:text-6xl font-display font-bold text-white mb-4">
                    Welcome, <span class="gradient-text neon-text">{{ auth()->user()->name }}</span>! 
                    @if(auth()->user()->role === 'admin')
                        👑
                    @elseif(auth()->user()->role === 'curator')
                        ⭐
                    @else
                        🎨
                    @endif
                </h1>
                <p class="text-gray-400 text-lg">
                    @if(auth()->user()->role === 'admin')
                        Admin Dashboard - Manage the entire platform
                    @elseif(auth()->user()->role === 'curator')
                        Curator Dashboard - Review and feature artworks
                    @else
                        Here's what's happening with your art
                    @endif
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 animate-fade-in-up animation-delay-200">
                @if(auth()->user()->role === 'admin')
                    <!-- Admin Stats -->
                    <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="text-4xl mb-2">👥</div>
                        <div class="font-bold text-3xl gradient-text">{{ \App\Models\User::count() }}</div>
                        <div class="text-gray-400 text-sm mt-1">Total Users</div>
                    </div>

                    <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="text-4xl mb-2">🎨</div>
                        <div class="font-bold text-3xl gradient-text">{{ \App\Models\Artwork::count() }}</div>
                        <div class="text-gray-400 text-sm mt-1">Total Artworks</div>
                    </div>

                    <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="text-4xl mb-2">🏆</div>
                        <div class="font-bold text-3xl gradient-text">{{ \App\Models\Challenge::where('status', 'active')->count() }}</div>
                        <div class="text-gray-400 text-sm mt-1">Active Challenges</div>
                    </div>

                    <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="text-4xl mb-2">⏳</div>
                        <div class="font-bold text-3xl gradient-text">{{ \App\Models\Artwork::where('status', 'pending')->count() }}</div>
                        <div class="text-gray-400 text-sm mt-1">Pending Reviews</div>
                    </div>

                @elseif(auth()->user()->role === 'curator')
                    <!-- Curator Stats -->
                    <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="text-4xl mb-2">⏳</div>
                        <div class="font-bold text-3xl gradient-text">{{ \App\Models\Artwork::where('status', 'pending')->count() }}</div>
                        <div class="text-gray-400 text-sm mt-1">Pending Reviews</div>
                    </div>

                    <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="text-4xl mb-2">✅</div>
                        <div class="font-bold text-3xl gradient-text">{{ auth()->user()->reviewed_today ?? 0 }}</div>
                        <div class="text-gray-400 text-sm mt-1">Reviewed Today</div>
                    </div>

                    <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="text-4xl mb-2">⭐</div>
                        <div class="font-bold text-3xl gradient-text">{{ \App\Models\Artwork::where('is_featured', true)->count() }}</div>
                        <div class="text-gray-400 text-sm mt-1">Featured Artworks</div>
                    </div>

                    <div class="glass rounded-2xl p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="text-4xl mb-2">📊</div>
                        <div class="font-bold text-3xl gradient-text">{{ \App\Models\Artwork::where('status', 'approved')->count() }}</div>
                        <div class="text-gray-400 text-sm mt-1">Total Approved</div>
                    </div>

                @else
                    <!-- Member Stats -->
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
                @endif
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
                    @if(auth()->user()->role === 'admin')
                        <!-- Admin Actions -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="p-6 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300 group">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center group-hover:bg-purple-500/30 transition-all">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Admin Dashboard</div>
                                    <div class="text-sm text-gray-400">Manage platform</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.users') }}" 
                           class="p-6 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300 group">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full bg-artoria-500/20 flex items-center justify-center group-hover:bg-artoria-500/30 transition-all">
                                    <svg class="w-6 h-6 text-artoria-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Manage Users</div>
                                    <div class="text-sm text-gray-400">Control user accounts</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.challenges') }}" 
                           class="p-6 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300 group">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full bg-pink-500/20 flex items-center justify-center group-hover:bg-pink-500/30 transition-all">
                                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Manage Challenges</div>
                                    <div class="text-sm text-gray-400">Create & manage</div>
                                </div>
                            </div>
                        </a>

                    @elseif(auth()->user()->role === 'curator')
                        <!-- Curator Actions -->
                        <a href="{{ route('curator.pending') }}" 
                           class="p-6 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300 group">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full bg-artoria-500/20 flex items-center justify-center group-hover:bg-artoria-500/30 transition-all">
                                    <svg class="w-6 h-6 text-artoria-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Review Artworks</div>
                                    <div class="text-sm text-gray-400">Approve submissions</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('curator.featured') }}" 
                           class="p-6 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300 group">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full bg-pink-500/20 flex items-center justify-center group-hover:bg-pink-500/30 transition-all">
                                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Feature Artworks</div>
                                    <div class="text-sm text-gray-400">Manage featured</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('artworks.index') }}" 
                           class="p-6 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300 group">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center group-hover:bg-purple-500/30 transition-all">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Browse Artworks</div>
                                    <div class="text-sm text-gray-400">View all artworks</div>
                                </div>
                            </div>
                        </a>

                    @else
                        <!-- Member Actions -->
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
                    @endif
                </div>
            </div>

            <!-- Success Message -->
            <div class="glass rounded-2xl p-6 text-center animate-fade-in-up animation-delay-600">
                <div class="text-6xl mb-4">
                    @if(auth()->user()->role === 'admin')
                        👑
                    @elseif(auth()->user()->role === 'curator')
                        ⭐
                    @else
                        🎉
                    @endif
                </div>
                <p class="text-xl text-white font-semibold mb-2">
                    @if(auth()->user()->role === 'admin')
                        Admin Panel Active
                    @elseif(auth()->user()->role === 'curator')
                        Curator Dashboard Ready
                    @else
                        You're logged in!
                    @endif
                </p>
                <p class="text-gray-400">
                    @if(auth()->user()->role === 'admin')
                        Manage the entire platform and keep the community thriving
                    @elseif(auth()->user()->role === 'curator')
                        Review and feature amazing artworks from the community
                    @else
                        Start creating and sharing your amazing artworks
                    @endif
                </p>
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