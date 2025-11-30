@extends('layouts.app')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-display font-bold text-white mb-2">
                    User <span class="gradient-text">Details</span>
                </h1>
                <p class="text-gray-400">Detailed information about {{ $user->name }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Users
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: User Profile --}}
        <div class="lg:col-span-1">
            <div class="glass rounded-2xl p-6 sticky top-8">
                {{-- Profile Picture --}}
                <div class="text-center mb-6">
                    @if($user->profile_picture)
                        <img src="{{ Storage::url($user->profile_picture) }}" 
                             alt="{{ $user->name }}" 
                             class="w-32 h-32 rounded-full object-cover mx-auto ring-4 ring-artoria-500 mb-4">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-artoria-500 to-pink-500 flex items-center justify-center text-white font-bold text-4xl mx-auto ring-4 ring-artoria-500 mb-4">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <h2 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h2>
                    <p class="text-gray-400 text-sm mb-3">{{ $user->email }}</p>
                    
                    {{-- Role & Status Badges --}}
                    <div class="flex items-center justify-center space-x-2 mb-4">
                        <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $user->role === 'admin' ? 'bg-red-500/20 text-red-300' : ($user->role === 'curator' ? 'bg-blue-500/20 text-blue-300' : 'bg-green-500/20 text-green-300') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $user->status === 'active' ? 'bg-green-500/20 text-green-300' : ($user->status === 'pending' ? 'bg-yellow-500/20 text-yellow-300' : 'bg-red-500/20 text-red-300') }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                </div>

                {{-- Bio --}}
                @if($user->bio)
                    <div class="mb-6 pb-6 border-b border-white/10">
                        <h3 class="text-sm font-semibold text-gray-300 mb-2">Bio</h3>
                        <p class="text-gray-400 text-sm">{{ $user->bio }}</p>
                    </div>
                @endif

                {{-- Brand Info (for curators) --}}
                @if($user->role === 'curator' && ($user->brand_name || $user->brand_description))
                    <div class="mb-6 pb-6 border-b border-white/10">
                        <h3 class="text-sm font-semibold text-gray-300 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Brand Information
                        </h3>
                        @if($user->brand_name)
                            <p class="text-white font-semibold mb-1">{{ $user->brand_name }}</p>
                        @endif
                        @if($user->brand_description)
                            <p class="text-gray-400 text-sm">{{ $user->brand_description }}</p>
                        @endif
                    </div>
                @endif

                {{-- Account Info --}}
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">User ID</span>
                        <span class="text-white font-mono">{{ $user->id }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Joined</span>
                        <span class="text-white">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Last Active</span>
                        <span class="text-white">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                @if($user->id !== auth()->id())
                    <div class="mt-6 pt-6 border-t border-white/10 space-y-3">
                        @if($user->status === 'active')
                            <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to suspend this user?')"
                                        class="w-full px-4 py-2 bg-yellow-500/20 hover:bg-yellow-500/30 border border-yellow-500/40 text-yellow-300 font-semibold rounded-xl transition-all flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    Suspend User
                                </button>
                            </form>
                        @elseif($user->status === 'suspended')
                            <form action="{{ route('admin.users.activate', $user) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-green-500/20 hover:bg-green-500/30 border border-green-500/40 text-green-300 font-semibold rounded-xl transition-all flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Activate User
                                </button>
                            </form>
                        @endif

                        @if($user->role === 'curator' && $user->status === 'pending')
                            <div class="grid grid-cols-2 gap-3">
                                <form action="{{ route('admin.curators.approve', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Approve this curator application?')"
                                            class="w-full px-4 py-2 bg-green-500/20 hover:bg-green-500/30 border border-green-500/40 text-green-300 font-semibold rounded-xl transition-all">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.curators.reject', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Reject this curator application?')"
                                            class="w-full px-4 py-2 bg-red-500/20 hover:bg-red-500/30 border border-red-500/40 text-red-300 font-semibold rounded-xl transition-all">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        @endif

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Permanently delete this user? This action cannot be undone!')"
                                    class="w-full px-4 py-2 bg-red-500/20 hover:bg-red-500/30 border border-red-500/40 text-red-300 font-semibold rounded-xl transition-all flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete User
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Stats & Activity --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="glass rounded-2xl p-6 text-center">
                    <div class="w-12 h-12 bg-artoria-500/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $stats['artworks_count'] ?? 0 }}</p>
                    <p class="text-gray-400 text-sm">Artworks</p>
                </div>

                <div class="glass rounded-2xl p-6 text-center">
                    <div class="w-12 h-12 bg-pink-500/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $stats['likes_received'] ?? 0 }}</p>
                    <p class="text-gray-400 text-sm">Likes Received</p>
                </div>

                <div class="glass rounded-2xl p-6 text-center">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $stats['comments_count'] ?? 0 }}</p>
                    <p class="text-gray-400 text-sm">Comments</p>
                </div>

                <div class="glass rounded-2xl p-6 text-center">
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold text-white mb-1">{{ $stats['profile_views'] ?? 0 }}</p>
                    <p class="text-gray-400 text-sm">Profile Views</p>
                </div>
            </div>

            {{-- Curator Stats (if applicable) --}}
            @if($user->role === 'curator')
                <div class="glass rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        Curator Activity
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-black/30 rounded-xl p-4 border border-white/5">
                            <p class="text-gray-400 text-sm mb-1">Challenges Created</p>
                            <p class="text-2xl font-bold text-white">{{ $stats['challenges_created'] ?? 0 }}</p>
                        </div>
                        <div class="bg-black/30 rounded-xl p-4 border border-white/5">
                            <p class="text-gray-400 text-sm mb-1">Challenge Entries</p>
                            <p class="text-2xl font-bold text-white">{{ $stats['challenge_submissions'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Recent Artworks --}}
            @if($user->artworks->isNotEmpty())
                <div class="glass rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Recent Artworks
                        </h3>
                        <a href="{{ route('profile.show', $user) }}" class="text-artoria-400 hover:text-artoria-300 text-sm font-semibold">
                            View All →
                        </a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($user->artworks->take(6) as $artwork)
                            <a href="{{ route('artworks.show', $artwork) }}" class="group relative aspect-square rounded-xl overflow-hidden">
                                <img src="{{ Storage::url($artwork->image_path) }}" 
                                     alt="{{ $artwork->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="absolute bottom-0 left-0 right-0 p-3">
                                        <p class="text-white font-semibold text-sm truncate">{{ $artwork->title }}</p>
                                        <div class="flex items-center space-x-3 mt-1 text-xs text-gray-300">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $artwork->likes_count }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $artwork->views_count }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .glass {
        background: rgba(17, 24, 39, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>
@endpush
@endsection