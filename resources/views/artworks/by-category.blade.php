@extends('layouts.app')

@section('title', $category->name . ' Artworks')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-gray-400">{{ $category->description }}</p>
            @endif
            <div class="mt-4">
                <span class="badge-red">{{ $artworks->total() }} artworks</span>
            </div>
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
                <h3 class="text-2xl font-bold text-white mb-2">No artworks in this category yet</h3>
                <p class="text-gray-400 mb-6">Be the first to upload in {{ $category->name }}</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('artworks.index') }}" class="btn-secondary">Browse All</a>
                    @auth
                        @if(auth()->user()->isMember() || auth()->user()->isCurator())
                            <a href="{{ route('artworks.create') }}" class="btn-primary">Upload Artwork</a>
                        @endif
                    @endauth
                </div>
            </div>
        @endif
    </div>
</div>
@endsection