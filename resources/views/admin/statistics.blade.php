@extends('layouts.app')

@section('title', 'Admin Statistics')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                <span class="gradient-text neon-text">Platform Statistics</span> 📊
            </h1>
            <p class="text-gray-400">Comprehensive platform analytics and insights</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                <div class="text-4xl font-bold gradient-text mb-1">{{ $userStats['total_users'] }}</div>
                <div class="text-gray-400 text-sm">Registered Users</div>
                <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                    <span class="text-green-400">+{{ $userStats['active_users'] }} active</span>
                    <span class="text-red-400">{{ $userStats['suspended_users'] }} suspended</span>
                </div>
            </div>

            <div class="stat-card group hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold gradient-text mb-1">{{ $contentStats['total_artworks'] }}</div>
                <div class="text-gray-400 text-sm">Total Artworks</div>
                <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                    <span class="text-green-400">{{ $contentStats['total_likes'] }} likes</span>
                    <span class="text-blue-400">{{ $contentStats['total_views'] }} views</span>
                </div>
            </div>

            <div class="stat-card group hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold gradient-text mb-1">{{ $contentStats['total_comments'] }}</div>
                <div class="text-gray-400 text-sm">Total Comments</div>
                <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                    <span class="text-yellow-400">{{ $contentStats['total_favorites'] }} favorites</span>
                </div>
            </div>

            <div class="stat-card group hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold gradient-text mb-1">{{ $challengeStats['total_challenges'] }}</div>
                <div class="text-gray-400 text-sm">Total Challenges</div>
                <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between text-xs">
                    <span class="text-green-400">{{ $challengeStats['active_challenges'] }} active</span>
                    <span class="text-gray-400">{{ $challengeStats['ended_challenges'] }} ended</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

<div class="glass rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        User Growth (Last 6 Months)
    </h2>
    <div class="h-64">
        <div class="flex items-end h-48 gap-2 mt-4">
            @php
                // Convert monthly growth data to array for easier access
                $monthlyData = [];
                foreach($monthlyGrowth as $data) {
                    $monthlyData[$data->month] = $data->count;
                }
                
                // Get last 6 months
                $months = [];
                for($i = 5; $i >= 0; $i--) {
                    $months[] = now()->subMonths($i)->format('Y-m');
                }
                
                // Find max value for scaling
                $maxValue = max(array_merge(array_values($monthlyData), [1])); // Avoid division by zero
            @endphp
            
            @foreach($months as $month)
                @php
                    $count = $monthlyData[$month] ?? 0;
                    $heightPercentage = ($count / $maxValue) * 100;
                @endphp
                <div class="flex flex-col items-center flex-1">
                    <div class="text-xs text-gray-400 mb-1">{{ $count }}</div>
                    <div 
                        class="w-full bg-gradient-to-t from-artoria-500 to-pink-500 rounded-t-lg transition-all duration-500 ease-out"
                        style="height: {{ $heightPercentage }}%; min-height: 4px;"
                        title="{{ $month }}: {{ $count }} users">
                    </div>
                    <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($month)->format('M') }}</div>
                </div>
            @endforeach
        </div>
        
        <div class="flex justify-center mt-4">
            <div class="flex items-center">
                <div class="w-3 h-3 bg-gradient-to-r from-artoria-500 to-pink-500 rounded mr-2"></div>
                <span class="text-xs text-gray-400">New Users</span>
            </div>
        </div>
    </div>
</div>

            <div class="glass rounded-2xl p-6">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Top Categories
                </h2>
                <div class="space-y-4">
                    @foreach($categoryDistribution as $category)
                        <div class="flex items-center justify-between p-3 glass-hover rounded-xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">{{ $category->name }}</h4>
                                    <p class="text-xs text-gray-400">{{ $category->artworks_count }} artworks</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-white font-bold">{{ $category->artworks_count }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="glass rounded-2xl p-6">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Top Artists
                </h2>
                <div class="space-y-4">
                    @foreach($topContributors as $artist)
                        <a href="{{ route('profile.show', $artist) }}" class="flex items-center justify-between p-3 glass-hover rounded-xl group">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $artist->profile_picture_url }}" 
                                     alt="{{ $artist->display_name }}" 
                                     class="w-12 h-12 rounded-lg object-cover">
                                <div>
                                    <h4 class="text-white font-semibold group-hover:text-artoria-400 transition-colors">
                                        {{ $artist->display_name }}
                                    </h4>
                                    <p class="text-xs text-gray-400">{{ $artist->artworks_count }} artworks</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-white font-bold">{{ $artist->artworks_count }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="glass rounded-2xl p-6">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    Most Popular Artworks
                </h2>
                <div class="space-y-4">
                    @foreach($topArtworks as $artwork)
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
                                    <span class="text-xs text-artoria-400 font-semibold"> {{ $artwork->likes_count }} likes</span>
                                    <span class="text-xs text-gray-500"> {{ $artwork->views_count }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="glass rounded-2xl p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-yellow-500/20 to-orange-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1h2a1 1 0 011 1v3"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold gradient-text mb-2">{{ $moderationStats['total_reports'] }}</div>
                <div class="text-gray-400">Total Reports</div>
                <div class="mt-2 text-sm text-gray-500">
                    <span class="text-green-400">{{ $moderationStats['pending_reports'] }} pending</span>
                    /
                    <span class="text-blue-400">{{ $moderationStats['reviewed_reports'] }} reviewed</span>
                </div>
            </div>

            <div class="glass rounded-2xl p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold gradient-text mb-2">{{ $challengeStats['total_submissions'] }}</div>
                <div class="text-gray-400">Challenge Entries</div>
                <div class="mt-2 text-sm text-gray-500">
                    <span class="text-green-400">{{ $userStats['curators'] }} active curators</span>
                </div>
            </div>

            <div class="glass rounded-2xl p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold gradient-text mb-2">{{ $userStats['members'] }}</div>
                <div class="text-gray-400">Total Members</div>
                <div class="mt-2 text-sm text-gray-500">
                    <span class="text-blue-400">{{ $userStats['curators'] }} curators</span>
                </div>
            </div>

            <div class="glass rounded-2xl p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-red-500/20 to-pink-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold gradient-text mb-2">{{ $userStats['admins'] }}</div>
                <div class="text-gray-400">Admin Users</div>
                <div class="mt-2 text-sm text-gray-500">
                    <span class="text-yellow-400">{{ $userStats['pending_users'] }} pending</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-card {
    @apply glass rounded-2xl p-6 hover:scale-105 transition-all duration-300 group;
}

.glass-hover {
    @apply glass rounded-xl p-3 hover:bg-white/10 transition-colors;
}

.gradient-text {
    @apply bg-gradient-to-r from-artoria-400 to-pink-400 bg-clip-text text-transparent;
}

.neon-text {
    text-shadow: 0 0 10px rgba(139, 92, 246, 0.5);
}
</style>
@endsection