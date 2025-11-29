@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-6xl font-display font-bold text-white mb-2">
                <span class="gradient-text neon-text">Admin Control Center</span> 🛡️
            </h1>
            <p class="text-gray-400">Complete platform oversight and management</p>
        </div>

        <!-- Primary Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="stat-card group hover:scale-105 border-2 border-artoria-500/20">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-artoria-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-neon-red">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-400">Total</div>
                    </div>
                </div>
                <div class="text-4xl font-bold gradient-text mb-1">{{ $stats['total_users'] }}</div>
                <div class="text-gray-400 text-sm">Registered Users</div>
                <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                    <span class="text-green-400">+{{ $stats['total_members'] }} members</span>
                    <span class="text-blue-400">{{ $stats['total_curators'] }} curators</span>
                </div>
            </div>

            <!-- Pending Curators -->
            <div class="stat-card group hover:scale-105 {{ $stats['pending_curators'] > 0 ? 'border-2 border-yellow-500/30 animate-pulse-slow' : '' }}">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    @if($stats['pending_curators'] > 0)
                        <div class="badge-yellow animate-bounce">Needs Action!</div>
                    @endif
                </div>
                <div class="text-4xl font-bold gradient-text mb-1">{{ $stats['pending_curators'] }}</div>
                <div class="text-gray-400 text-sm">Pending Curators</div>
                @if($stats['pending_curators'] > 0)
                    <a href="{{ route('admin.curators.pending') }}" class="mt-3 btn-primary text-xs py-2 w-full text-center block">
                        Review Now →
                    </a>
                @endif
            </div>

            <!-- Pending Reports -->
            <div class="stat-card group hover:scale-105 {{ $stats['pending_reports'] > 0 ? 'border-2 border-red-500/30 animate-pulse-slow' : '' }}">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    @if($stats['pending_reports'] > 0)
                        <div class="badge-red animate-bounce">Urgent!</div>
                    @endif
                </div>
                <div class="text-4xl font-bold gradient-text mb-1">{{ $stats['pending_reports'] }}</div>
                <div class="text-gray-400 text-sm">Pending Reports</div>
                @if($stats['pending_reports'] > 0)
                    <a href="{{ route('admin.moderation.index') }}" class="mt-3 btn-primary text-xs py-2 w-full text-center block">
                        Moderate →
                    </a>
                @endif
            </div>

            <!-- Total Content -->
            <div class="stat-card group hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold gradient-text mb-1">{{ $stats['total_artworks'] }}</div>
                <div class="text-gray-400 text-sm">Total Artworks</div>
                <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                    <span class="text-green-400">{{ $stats['active_challenges'] }} challenges</span>
                    <span class="text-blue-400">{{ $stats['total_categories'] }} categories</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('admin.users.index') }}" class="glass rounded-2xl p-6 hover:scale-105 hover:shadow-neon-red transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold group-hover:text-artoria-400 transition-colors">User Management</h3>
                        <p class="text-xs text-gray-400">Manage all users</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="glass rounded-2xl p-6 hover:scale-105 hover:shadow-neon-red transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold group-hover:text-artoria-400 transition-colors">Categories</h3>
                        <p class="text-xs text-gray-400">Manage categories</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.moderation.index') }}" class="glass rounded-2xl p-6 hover:scale-105 hover:shadow-neon-red transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500/20 to-pink-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold group-hover:text-artoria-400 transition-colors">Moderation</h3>
                        <p class="text-xs text-gray-400">Review reports</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.statistics') }}" class="glass rounded-2xl p-6 hover:scale-105 hover:shadow-neon-red transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500/20 to-orange-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold group-hover:text-artoria-400 transition-colors">Statistics</h3>
                        <p class="text-xs text-gray-400">View analytics</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Recent Users -->
            <div class="glass rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Recent Users
                    </h2>
                    <a href="{{ route('admin.users.index') }}" class="text-artoria-400 hover:text-artoria-300 text-sm font-semibold">
                        View All →
                    </a>
                </div>
                <div class="space-y-3">
                    @foreach($recentUsers as $user)
                        <div class="flex items-center justify-between p-3 glass-hover rounded-xl group">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $user->profile_picture_url }}" 
                                     alt="{{ $user->display_name }}" 
                                     class="w-10 h-10 rounded-lg object-cover">
                                <div>
                                    <h4 class="text-white font-semibold text-sm group-hover:text-artoria-400 transition-colors">
                                        {{ $user->display_name }}
                                    </h4>
                                    <p class="text-xs text-gray-400 capitalize">{{ $user->role }} • {{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn-secondary text-xs py-1 px-3">
                                View
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Artworks -->
            <div class="glass rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Recent Artworks
                    </h2>
                </div>
                <div class="space-y-3">
                    @foreach($recentArtworks as $artwork)
                        <a href="{{ route('artworks.show', $artwork) }}" class="flex items-center space-x-3 p-3 glass-hover rounded-xl group">
                            <img src="{{ $artwork->image_url }}" 
                                 alt="{{ $artwork->title }}" 
                                 class="w-16 h-16 rounded-lg object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-white font-semibold text-sm truncate group-hover:text-artoria-400 transition-colors">
                                    {{ $artwork->title }}
                                </h4>
                                <p class="text-xs text-gray-400">by {{ $artwork->user->display_name }}</p>
                                <div class="flex items-center space-x-3 mt-1 text-xs text-gray-500">
                                    <span>❤️ {{ $artwork->likes_count }}</span>
                                    <span>👁️ {{ $artwork->views_count }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pending Reports & Popular Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Pending Reports -->
            @if($recentReports->count() > 0)
                <div class="glass rounded-2xl p-6 border-2 border-red-500/20">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Pending Reports
                        </h2>
                        <a href="{{ route('admin.moderation.index') }}" class="text-artoria-400 hover:text-artoria-300 text-sm font-semibold">
                            View All →
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentReports as $report)
                            <div class="p-4 bg-red-500/5 border border-red-500/20 rounded-xl">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="badge-red text-xs">
                                                {{ class_basename($report->reportable_type) }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                by {{ $report->reporter->display_name }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-300 line-clamp-2">{{ $report->reason }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $report->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.reports.show', $report) }}" class="btn-primary text-xs py-1 px-4 mt-2 inline-block">
                                    Review →
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Popular Artworks -->
            <div class="glass rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        Most Popular
                    </h2>
                </div>
                <div class="space-y-3">
                    @foreach($popularArtworks as $artwork)
                        <a href="{{ route('artworks.show', $artwork) }}" class="flex items-center space-x-3 p-3 glass-hover rounded-xl group">
                            <img src="{{ $artwork->image_url }}" 
                                 alt="{{ $artwork->title }}" 
                                 class="w-16 h-16 rounded-lg object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-white font-semibold text-sm truncate group-hover:text-artoria-400 transition-colors">
                                    {{ $artwork->title }}
                                </h4>
                                <p class="text-xs text-gray-400">by {{ $artwork->user->display_name }}</p>
                                <div class="flex items-center space-x-3 mt-1">
                                    <span class="text-xs text-artoria-400 font-semibold">❤️ {{ $artwork->likes_count }} likes</span>
                                    <span class="text-xs text-gray-500">👁️ {{ $artwork->views_count }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection