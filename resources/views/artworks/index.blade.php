@extends('layouts.app')

@section('title', 'Explore Artworks')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Explore Artworks
            </h1>
            <p class="text-gray-400">Discover amazing art from talented creators</p>
        </div>

        <!-- Filters -->
        <div class="mb-8 glass rounded-2xl p-6">
            <form action="{{ route('artworks.index') }}" method="GET" class="space-y-4">
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search artworks by title or description..." 
                               class="input-artoria">
                    </div>

                    <!-- Category Filter -->
<div class="lg:w-64">
    <select name="category" class="input-artoria">
        <option value="">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

                    <!-- Sort -->
                    <div class="lg:w-48">
                        <select name="sort" class="input-artoria" onchange="this.form.submit()">
                            <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="views" {{ $sort == 'views' ? 'selected' : '' }}>Most Viewed</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary lg:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="ml-2">Search</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        <div class="mb-6 flex items-center justify-between">
            <p class="text-gray-400">
                Found <span class="text-white font-semibold">{{ $artworks->total() }}</span> artworks
            </p>
            @auth
                @if(auth()->user()->isMember() || auth()->user()->isCurator())
                    <a href="{{ route('artworks.create') }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="ml-2">Upload Artwork</span>
                    </a>
                @endif
            @endauth
        </div>

        <!-- Artworks Grid -->
        @if($artworks->count() > 0)
            <div class="masonry-grid mb-12">
                @foreach($artworks as $artwork)
                    <x-artwork-card :artwork="$artwork" />
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
                <h3 class="text-2xl font-bold text-white mb-2">No artworks found</h3>
                <p class="text-gray-400 mb-6">Try adjusting your filters or search terms</p>
                <a href="{{ route('artworks.index') }}" class="btn-secondary">Clear Filters</a>
            </div>
        @endif
    </div>
</div>
@endsection