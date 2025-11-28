@extends('layouts.app')

@section('title', 'My Artworks')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                    My Artworks
                </h1>
                <p class="text-gray-400">Manage your creative portfolio</p>
            </div>
            <a href="{{ route('artworks.create') }}" class="btn-primary mt-4 md:mt-0 flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Upload New</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card">
                <div class="text-4xl font-bold gradient-text mb-2">{{ $artworks->total() }}</div>
                <div class="text-gray-400 text-sm">Total Artworks</div>
            </div>
            <div class="stat-card">
                <div class="text-4xl font-bold gradient-text mb-2">{{ auth()->user()->artworks()->sum('likes_count') }}</div>
                <div class="text-gray-400 text-sm">Total Likes</div>
            </div>
            <div class="stat-card">
                <div class="text-4xl font-bold gradient-text mb-2">{{ auth()->user()->artworks()->sum('views_count') }}</div>
                <div class="text-gray-400 text-sm">Total Views</div>
            </div>
            <div class="stat-card">
                <div class="text-4xl font-bold gradient-text mb-2">{{ auth()->user()->artworks()->withCount('comments')->get()->sum('comments_count') }}</div>
                <div class="text-gray-400 text-sm">Total Comments</div>
            </div>
        </div>

        <!-- Artworks Grid -->
        @if($artworks->count() > 0)
            <div class="masonry-grid mb-12">
                @foreach($artworks as $artwork)
                    <div class="masonry-item">
                        <div class="artwork-card glass rounded-2xl overflow-hidden hover:shadow-neon-red transition-all duration-300">
                            <a href="{{ route('artworks.show', $artwork) }}" class="block relative">
                                <img src="{{ $artwork->image_url }}" 
                                     alt="{{ $artwork->title }}" 
                                     class="w-full h-auto object-cover">
                                
                                <div class="artwork-overlay">
                                    <div class="absolute inset-0 p-6 flex flex-col justify-between">
                                        <div>
                                            <h3 class="text-white font-bold text-lg mb-2">{{ $artwork->title }}</h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-300">
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $artwork->likes_count }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    {{ $artwork->views_count }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('artworks.edit', $artwork) }}" 
                                               class="flex-1 px-4 py-2 bg-white/10 backdrop-blur-xl text-white rounded-xl hover:bg-white/20 transition-all duration-300 text-center text-sm font-medium"
                                               onclick="event.stopPropagation()">
                                                Edit
                                            </a>
                                            <form action="{{ route('artworks.destroy', $artwork) }}" 
                                                  method="POST" 
                                                  class="flex-1"
                                                  onsubmit="return confirm('Delete this artwork?')"
                                                  onclick="event.stopPropagation()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-full px-4 py-2 bg-red-500/20 backdrop-blur-xl text-red-300 rounded-xl hover:bg-red-500/30 transition-all duration-300 text-center text-sm font-medium">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
        <div class="flex justify-center">
            {{ $artworks->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">No artworks yet</h3>
            <p class="text-gray-400 mb-6">Start building your portfolio by uploading your first artwork</p>
            <a href="{{ route('artworks.create') }}" class="btn-primary inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Upload Your First Artwork</span>
            </a>
        </div>
    @endif
</div>