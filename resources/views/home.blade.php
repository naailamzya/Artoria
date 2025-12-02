@extends('layouts.app')

@section('title', 'Showcase Your Art')

@section('content')

<section class="relative py-20 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto space-y-6">
            <h1 class="text-5xl md:text-7xl font-display font-bold text-white leading-tight animate-fade-in-up">
                Showcase Your
                <span class="gradient-text neon-text">Creative Vision</span>
            </h1>
            <p class="text-xl text-gray-300 animate-fade-in-up animation-delay-200">
                Join the world's most vibrant community of digital artists. Share your work, join challenges, and get discovered.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6 animate-fade-in-up animation-delay-400">
                @guest
                    <a href="{{ route('register') }}" class="btn-primary px-8 py-4 text-lg">
                        Start Creating
                        <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="{{ route('artworks.index') }}" class="btn-secondary px-8 py-4 text-lg">
                        Explore Artworks
                    </a>
                @else
                    @if(auth()->user()->role === 'admin')
\
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary px-8 py-4 text-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Go to Admin Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'curator')
                        <a href="{{ route('curator.pending') }}" class="btn-primary px-8 py-4 text-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Review Artworks
                        </a>
                    @else
                        <a href="{{ route('artworks.create') }}" class="btn-primary px-8 py-4 text-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Upload Your Art
                            <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </div>

    <div class="absolute top-1/4 left-0 w-72 h-72 bg-artoria-500/10 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl animate-float animation-delay-200"></div>
</section>

@if($featuredArtworks->count() > 0)
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">
                    Featured Artworks
                </h2>
                <p class="text-gray-400">Handpicked masterpieces from our community</p>
            </div>
            <a href="{{ route('artworks.index', ['sort' => 'popular']) }}" class="btn-ghost hidden sm:flex items-center space-x-2">
                <span>View All</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="masonry-grid" data-masonry-grid>
            @foreach($featuredArtworks as $artwork)
                <div class="masonry-item">
                    <x-artwork-card :artwork="$artwork" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($activeChallenges->count() > 0)
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">
                    Active Challenges
                </h2>
                <p class="text-gray-400">Compete with artists and win amazing prizes</p>
            </div>
            <a href="{{ route('challenges.index') }}" class="btn-ghost hidden sm:flex items-center space-x-2">
                <span>View All</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($activeChallenges as $challenge)
                <x-challenge-card :challenge="$challenge" />
            @endforeach
        </div>
    </div>
</section>
@endif

@if($popularTags->count() > 0)
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">
                Trending Tags
            </h2>
            <p class="text-gray-400">Discover art by popular themes</p>
        </div>

        <div class="flex flex-wrap justify-center gap-3">
            @foreach($popularTags as $tag)
            <span class="tag cursor-default"
                style="font-size: {{ 12 + min($tag->usage_count / 5, 8) }}px">
                #{{ $tag->name}}
            <span class="ml-1 opacity-60">({{ $tag->usage_count }}) </span>
        </span>
    @endforeach
    </div>
    </div>
</section>
@endif

@if($popularArtworks->count() > 0)
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">
                    Popular Right Now
                </h2>
                <p class="text-gray-400">Most loved by the community</p>
            </div>
        </div>

        <div class="masonry-grid" data-masonry-grid>
            @foreach($popularArtworks as $artwork)
                <div class="masonry-item">
                    <x-artwork-card :artwork="$artwork" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($latestArtworks->count() > 0)
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">
                    Fresh Uploads
                </h2>
                <p class="text-gray-400">Latest creations from our artists</p>
            </div>
            <a href="{{ route('artworks.index') }}" class="btn-ghost hidden sm:flex items-center space-x-2">
                <span>View All</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="masonry-grid" data-masonry-grid>
            @foreach($latestArtworks as $artwork)
                <div class="masonry-item">
                    <x-artwork-card :artwork="$artwork" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="glass rounded-3xl p-12 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-artoria-500/20 to-pink-500/20"></div>
            
            <div class="relative z-10 max-w-3xl mx-auto space-y-6">
                <h2 class="text-4xl md:text-5xl font-display font-bold text-white">
                    Ready to Share Your Art?
                </h2>
                <p class="text-xl text-gray-300">
                    Join thousands of artists showcasing their creativity on Artoria
                </p>
                @guest
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6">
                        <a href="{{ route('register') }}" class="btn-primary px-8 py-4 text-lg">
                            Join Artoria Free
                        </a>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary px-8 py-4 text-lg">
                                Go to Admin Panel
                            </a>
                        @elseif(auth()->user()->role === 'curator')
                            <a href="{{ route('curator.pending') }}" class="btn-primary px-8 py-4 text-lg">
                                Review Pending Artworks
                            </a>
                        @else
                            <a href="{{ route('artworks.create') }}" class="btn-primary px-8 py-4 text-lg">
                                Upload Your First Artwork
                            </a>
                        @endif
                    </div>
                @endguest
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out forwards;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }

    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }

    .masonry-grid {
        position: relative;
    }

    .masonry-item {
        width: 100%;
        margin-bottom: 1.5rem;
    }

    @media (min-width: 768px) {
        .masonry-item {
            width: calc(50% - 0.75rem);
        }
    }

    @media (min-width: 1024px) {
        .masonry-item {
            width: calc(33.333% - 1rem);
        }
    }

    @media (min-width: 1280px) {
        .masonry-item {
            width: calc(25% - 1.125rem);
        }
    }

    .masonry-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .masonry-item:hover {
        transform: translateY(-4px);
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    .masonry-grid[data-masonry-grid] {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .masonry-grid[data-masonry-grid].masonry-loaded {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const masonryGrids = document.querySelectorAll('[data-masonry-grid]');
    
    masonryGrids.forEach(function(grid) {
        imagesLoaded(grid, function() {
            const msnry = new Masonry(grid, {
                itemSelector: '.masonry-item',
                columnWidth: '.masonry-item',
                percentPosition: true,
                gutter: 24, 
                horizontalOrder: true,
                transitionDuration: '0.3s',
                stagger: 30
            });

            grid.classList.add('masonry-loaded');

            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    msnry.layout();
                }, 250);
            });
        });
    });

    document.addEventListener('lazyloaded', function(e) {
        const grid = e.target.closest('[data-masonry-grid]');
        if (grid && grid.masonryInstance) {
            grid.masonryInstance.layout();
        }
    });
});
</script>
@endpush
@endsection