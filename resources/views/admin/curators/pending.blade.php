@extends('layouts.app')

@section('title', 'Pending Curator Applications')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Pending Curator Applications 🎯
            </h1>
            <p class="text-gray-400">Review and approve curator applications</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="stat-card">
                <div class="text-3xl font-bold gradient-text mb-1">{{ $pendingCurators->total() }}</div>
                <div class="text-gray-400 text-sm">Pending Applications</div>
            </div>
            <div class="stat-card">
                <div class="text-3xl font-bold gradient-text mb-1">{{ \App\Models\User::where('role', 'curator')->where('status', 'active')->count() }}</div>
                <div class="text-gray-400 text-sm">Active Curators</div>
            </div>
            <div class="stat-card">
                <div class="text-3xl font-bold gradient-text mb-1">{{ \App\Models\Challenge::count() }}</div>
                <div class="text-gray-400 text-sm">Total Challenges</div>
            </div>
        </div>

        <!-- Applications Grid -->
        @if($pendingCurators->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                @foreach($pendingCurators as $curator)
                    <div class="glass rounded-2xl p-6 border-2 border-yellow-500/30 hover:shadow-neon-red transition-all duration-300">
                        <!-- User Info -->
                        <div class="flex items-start space-x-4 mb-6">
                            <img src="{{ $curator->profile_picture_url }}" 
                                 alt="{{ $curator->display_name }}" 
                                 class="w-20 h-20 rounded-xl object-cover border-2 border-yellow-500/50">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-1">{{ $curator->name }}</h3>
                                <p class="text-gray-400 text-sm mb-2">{{ $curator->email }}</p>
                                <span class="badge-yellow text-xs">Applied {{ $curator->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Display Name -->
                        @if($curator->display_name)
                            <div class="mb-4">
                                <p class="text-xs text-gray-400 mb-1">Display Name</p>
                                <p class="text-white font-semibold">{{ $curator->display_name }}</p>
                            </div>
                        @endif

                        <!-- Bio -->
                        @if($curator->bio)
                            <div class="mb-4">
                                <p class="text-xs text-gray-400 mb-1">Bio</p>
                                <p class="text-gray-300 text-sm">{{ $curator->bio }}</p>
                            </div>
                        @endif

                        <!-- Social Links -->
                        @if($curator->instagram_link || $curator->behance_link || $curator->website_link)
                            <div class="mb-4">
                                <p class="text-xs text-gray-400 mb-2">Social Links</p>
                                <div class="flex flex-wrap gap-2">
                                    @if($curator->instagram_link)
                                        <a href="{{ $curator->instagram_link }}" target="_blank" class="badge-blue text-xs">
                                            Instagram
                                        </a>
                                    @endif
                                    @if($curator->behance_link)
                                        <a href="{{ $curator->behance_link }}" target="_blank" class="badge-blue text-xs">
                                            Behance
                                        </a>
                                    @endif
                                    @if($curator->website_link)
                                        <a href="{{ $curator->website_link }}" target="_blank" class="badge-blue text-xs">
                                            Website
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Portfolio Stats -->
                        <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-white/5 rounded-xl">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-artoria-400">{{ $curator->artworks_count }}</div>
                                <div class="text-xs text-gray-400">Artworks</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-artoria-400">{{ $curator->artworks->sum('likes_count') }}</div>
                                <div class="text-xs text-gray-400">Total Likes</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-artoria-400">{{ $curator->artworks->sum('views_count') }}</div>
                                <div class="text-xs text-gray-400">Total Views</div>
                            </div>
                        </div>

                        <!-- View Profile -->
                        <a href="{{ route('profile.show', $curator) }}" target="_blank" class="btn-secondary w-full mb-3 text-center">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            View Full Profile
                        </a>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <form action="{{ route('admin.curators.approve', $curator) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Approve {{ $curator->name }} as curator?')"
                                        class="w-full btn-primary flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Approve</span>
                                </button>
                            </form>

                            <form action="{{ route('admin.curators.reject', $curator) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Reject this curator application?')"
                                        class="w-full px-6 py-3 bg-red-500/20 text-red-300 font-semibold rounded-xl hover:bg-red-500/30 transition-all duration-300 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span>Reject</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $pendingCurators->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">All Caught Up! 🎉</h3>
                <p class="text-gray-400 mb-6">No pending curator applications at the moment</p>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Back to Dashboard</a>
            </div>
        @endif
    </div>
</div>
@endsection