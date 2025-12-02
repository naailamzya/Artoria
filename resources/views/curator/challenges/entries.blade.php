@extends('layouts.app')

@section('title', 'Challenge Entries - ' . $challenge->title)

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('curator.challenges.mine') }}" class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to My Challenges</span>
            </a>
        </div>

        <!-- Challenge Header -->
        <div class="glass rounded-3xl overflow-hidden mb-8">
            <div class="relative h-64">
                @if($challenge->banner_image)
                    <img src="{{ $challenge->banner_url }}" 
                         alt="{{ $challenge->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-artoria-500/20 to-pink-500/20"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-dark-900 to-transparent"></div>
            </div>
            
            <div class="p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-4xl font-display font-bold text-white mb-2">
                            {{ $challenge->title }}
                        </h1>
                        <div class="flex items-center space-x-4 text-gray-400">
                            <span>{{ $entries->total() }} Entries</span>
                            <span>•</span>
                            <span>Ends {{ $challenge->end_date->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0">
                        @if($challenge->status === 'active')
                            <span class="badge-green">Active</span>
                        @elseif($challenge->status === 'ended')
                            <span class="badge-gray">✓ Ended</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($entries->count() > 0)
            <div class="masonry-grid">
                @foreach($entries as $entry)
                    <div class="glass rounded-2xl overflow-hidden hover:scale-105 transition-all duration-300 group">
                        <!-- Artwork Image -->
                        <div class="relative aspect-square">
                            <img src="{{ $entry->artwork->image_url }}" 
                                 alt="{{ $entry->artwork->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            
                            <!-- Winner Badge -->
                            @if($entry->is_winner)
                                <div class="absolute top-4 right-4">
                                    <span class="badge-yellow backdrop-blur-xl">🏆 Winner</span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-artoria-400 transition-colors">
                                <a href="{{ route('artworks.show', $entry->artwork) }}">
                                    {{ $entry->artwork->title }}
                                </a>
                            </h3>
                            
                            <div class="flex items-center space-x-2 mb-4">
                                <img src="{{ $entry->user->profile_picture ? asset('storage/' . $entry->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($entry->user->name) }}" 
                                     alt="{{ $entry->user->name }}" 
                                     class="w-6 h-6 rounded-full">
                                <span class="text-sm text-gray-400">{{ $entry->user->name }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm text-gray-400 mb-4">
                                <div class="flex items-center space-x-4">
                                    <span> {{ $entry->artwork->likes_count }}</span>
                                    <span> {{ $entry->artwork->views_count }}</span>
                                </div>
                                <span>{{ $entry->created_at->diffForHumans() }}</span>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('artworks.show', $entry->artwork) }}" 
                                   class="flex-1 btn-secondary text-center text-sm py-2">
                                    View
                                </a>
                                
                                @if(!$entry->is_winner && $challenge->status === 'ended')
                                    <form action="{{ route('curator.challenges.select-winner', [$challenge, $entry]) }}" 
                                          method="POST" 
                                          class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="w-full btn-primary text-center text-sm py-2"
                                                onclick="return confirm('Are you sure you want to select this as the winner?')">
                                            Select Winner
                                        </button>
                                    </form>
                                @elseif($entry->is_winner)
                                    <form action="{{ route('curator.challenges.remove-winner', [$challenge, $entry]) }}" 
                                          method="POST" 
                                          class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl text-center text-sm py-2 transition-all"
                                                onclick="return confirm('Are you sure you want to remove this winner?')">
                                            Remove Winner
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($entries->hasPages())
                <div class="mt-8">
                    {{ $entries->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No Entries Yet</h3>
                <p class="text-gray-400 mb-6">This challenge hasn't received any submissions yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection