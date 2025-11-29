@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                My Favorites
            </h1>
            <p class="text-gray-400">Artworks you've saved for inspiration</p>
        </div>

        <!-- Count -->
        @if($favorites->count() > 0)
            <div class="mb-6">
                <p class="text-gray-400">
                    You have <span class="text-white font-semibold">{{ $favorites->total() }}</span> saved artworks
                </p>
            </div>
        @endif

        <!-- Favorites Grid -->
        @if($favorites->count() > 0)
            <div class="masonry-grid mb-12">
                @foreach($favorites as $favorite)
                    <x-artwork-card :artwork="$favorite->artwork" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $favorites->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No favorites yet</h3>
                <p class="text-gray-400 mb-6">Start saving artworks you love to build your collection</p>
                <a href="{{ route('artworks.index') }}" class="btn-primary inline-flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Explore Artworks</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection