@extends('layouts.app')

@section('title', 'Curator Dashboard')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Curator Dashboard <span class="gradient-text">🎯</span>
            </h1>
            <p class="text-gray-400">Manage your challenges and review submissions</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card group hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold gradient-text mb-1">{{ $stats['total_challenges'] }}</div>
                <div class="text-gray-400 text-sm">Total Challenges</div>
            </div>

            <div class="stat-card group hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold gradient-text mb-1">{{ $stats['active_challenges'] }}</div>
                <div class="text-gray-400 text-sm">Active Now</div>
            </div>

            <div class="stat-card group hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold gradient-text mb-1">{{ $stats['total_submissions'] }}</div>
                <div class="text-gray-400 text-sm">Total Submissions</div>
            </div>

            <div class="stat-card group hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold gradient-text mb-1">{{ $stats['total_participants'] }}</div>
                <div class="text-gray-400 text-sm">Participants</div>
            </div>
        </div>

        <!-- Quick Action -->
        <div class="mb-8">
            <a href="{{ route('curator.challenges.create') }}" class="glass rounded-2xl p-6 hover:scale-102 hover:shadow-neon-red transition-all duration-300 group flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-artoria-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white mb-1">Create New Challenge</h3>
                        <p class="text-gray-400">Launch a new art competition for the community</p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-artoria-400 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Active Challenges -->
        @if($activeChallenges->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Active Challenges
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeChallenges as $challenge)
                        <div class="glass rounded-2xl overflow-hidden hover:shadow-neon-red transition-all duration-300 group">
                            <div class="relative h-48">
                                <img src="{{ $challenge->banner_url }}" 
                                     alt="{{ $challenge->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-4 right-4">
                                    <span class="badge-green backdrop-blur-xl">🔥 Active</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-artoria-400 transition-colors">
                                    {{ $challenge->title }}
                                </h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-400 mb-4">
                                    <span>{{ $challenge->entries_count }} entries</span>
                                    <span>•</span>
                                    <span>{{ $challenge->end_date->diffForHumans() }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('curator.challenges.entries', $challenge) }}" class="flex-1 btn-primary text center text-sm py-2">
                                        View Entries
                                    </a>
                                    <a href="{{ route('curator.challenges.edit', $challenge) }}" class="flex-1 btn-secondary text center text-sm py-2">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Draft Challenges -->
    @if($draftChallenges->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Draft Challenges
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($draftChallenges as $challenge)
                    <div class="glass rounded-2xl p-6 border-2 border-dashed border-white/10">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-2">{{ $challenge->title }}</h3>
                                <span class="badge-yellow text-xs">Draft</span>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $challenge->description }}</p>
                        <div class="flex gap-2">
                            <a href="{{ route('curator.challenges.edit', $challenge) }}" class="flex-1 btn-primary text-center text-sm py-2">
                                Continue Editing
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Submissions -->
    @if($recentSubmissions->count() > 0)
        <div>
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Recent Submissions
            </h2>
            <div class="glass rounded-2xl p-6">
                <div class="space-y-4">
                    @foreach($recentSubmissions as $submission)
                        <a href="{{ route('artworks.show', $submission->artwork) }}" class="flex items-center space-x-4 p-3 glass-hover rounded-xl group">
                            <img src="{{ $submission->artwork->image_url }}" 
                                 alt="{{ $submission->artwork->title }}" 
                                 class="w-20 h-20 rounded-lg object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-semibold truncate group-hover:text-artoria-400 transition-colors">
                                    {{ $submission->artwork->title }}
                                </h3>
                                <p class="text-sm text-gray-400">
                                    by {{ $submission->user->display_name }} • {{ $submission->created_at->diffForHumans() }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Challenge: {{ $submission->challenge->title }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if($activeChallenges->count() === 0 && $draftChallenges->count() === 0)
        <div class="text-center py-20">
            <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-full flex items-center justify-center animate-pulse-slow">
                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">No Challenges Yet</h3>
            <p class="text-gray-400 mb-6">Create your first challenge and engage the community!</p>
            <a href="{{ route('curator.challenges.create') }}" class="btn-primary inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Create First Challenge</span>
            </a>
        </div>
    @endif
</div>
</div>
@endsection