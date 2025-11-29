@extends('layouts.app')

@section('title', 'Search: ' . $query)

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Search Results
            </h1>
            <p class="text-gray-400">
                Showing results for "<span class="text-white font-semibold">{{ $query }}</span>"
            </p>
            <div class="mt-4">
                <span class="badge-red">{{ $artworks->total() }} results found</span>
            </div>
        </div>

        <!-- Search Again -->
        <div class="mb-8 glass rounded-2xl p-6">
            <form action="{{ route('artworks.search') }}" method="GET" class="flex gap-4">
                <input type="text" 
                       name="q" 
                       value="{{ $query }}"
                       placeholder="Search artworks..." 
                       class="flex-1 input-artoria"
                       autofocus>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="ml-2">Search</span>
                </button>
            </form>
        </div>

        <!-- Results Grid -->
        @if($artworks->count() > 0)
            <div class="masonry-grid mb-12">
                @foreach($artworks as $artwork)
                    <x-artwork-card :artwork="$artwork" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $artworks->appends(['q' => $query])->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No results found</h3>
                <p class="text-gray-400 mb-6">Try different keywords or browse all artworks</p>
                <a href="{{ route('artworks.index') }}" class="btn-secondary">Browse All Artworks</a>
            </div>
        @endif
    </div>
</div>
@endsection