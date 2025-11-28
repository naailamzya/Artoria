@extends('layouts.app')

@section('title', $artwork->title)

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Artwork Image -->
                <div class="glass rounded-3xl overflow-hidden">
                    <img src="{{ $artwork->image_url }}" 
                         alt="{{ $artwork->title }}" 
                         class="w-full h-auto">
                </div>

                <!-- Action Buttons -->
                @auth
                    <div class="flex flex-wrap gap-3">
                        <!-- Like Button -->
                        @if(auth()->user()->isMember() || auth()->user()->isCurator())
                            <form action="{{ $hasLiked ? route('artworks.unlike', $artwork) : route('artworks.like', $artwork) }}" 
                                  method="POST" 
                                  class="inline-block">
                                @csrf
                                @if($hasLiked)
                                    @method('DELETE')
                                @endif
                                <button type="submit" class="btn-primary flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="{{ $hasLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span>{{ $hasLiked ? 'Liked' : 'Like' }}</span>
                                    <span class="badge-red">{{ $artwork->likes_count }}</span>
                                </button>
                            </form>

                            <!-- Favorite Button -->
                            <form action="{{ $hasFavorited ? route('artworks.unfavorite', $artwork) : route('artworks.favorite', $artwork) }}" 
                                  method="POST" 
                                  class="inline-block">
                                @csrf
                                @if($hasFavorited)
                                    @method('DELETE')
                                @endif
                                <button type="submit" class="btn-secondary flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="{{ $hasFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                    <span>{{ $hasFavorited ? 'Saved' : 'Save' }}</span>
                                </button>
                            </form>
                        @endif

                        <!-- Edit/Delete (Owner) -->
                        @can('update', $artwork)
                            <a href="{{ route('artworks.edit', $artwork) }}" class="btn-secondary flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>Edit</span>
                            </a>
                        @endcan

                        @can('delete', $artwork)
                            <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this artwork?')"
                                        class="btn-ghost text-red-400 hover:bg-red-500/10 flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Delete</span>
                                </button>
                            </form>
                        @endcan

                        <!-- Report (Not Owner) -->
                        @can('report', $artwork)
                            <button @click="$dispatch('report-modal')" 
                                    class="btn-ghost text-yellow-400 hover:bg-yellow-500/10 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                                </svg>
                                <span>Report</span>
                            </button>
                            <x-report-modal :action="route('artworks.report', $artwork)" type="artwork" />
                        @endcan
                    </div>
                @else
                    <div class="glass rounded-2xl p-6 text-center">
                        <p class="text-gray-300 mb-4">
                            <svg class="w-8 h-8 inline-block mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <br>
                            Please login to like, save, or comment on this artwork
                        </p>
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('login') }}" class="btn-primary">Login</a>
                            <a href="{{ route('register') }}" class="btn-secondary">Sign Up</a>
                        </div>
                    </div>
                @endauth

                <!-- Comments Section -->
                <div class="glass rounded-2xl p-6">
                    <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Comments ({{ $artwork->comments->count() }})
                    </h3>

                    <!-- Comment Form -->
                    @auth
                        @if(auth()->user()->isMember() || auth()->user()->isCurator())
                            <form action="{{ route('comments.store', $artwork) }}" method="POST" class="mb-6">
                                @csrf
                                <div class="flex space-x-3">
                                    <img src="{{ auth()->user()->profile_picture_url }}" 
                                         alt="{{ auth()->user()->display_name }}" 
                                         class="w-10 h-10 rounded-xl object-cover flex-shrink-0">
                                    <div class="flex-1">
                                        <textarea name="content" 
                                                  rows="3" 
                                                  placeholder="Share your thoughts..." 
                                                  required
                                                  class="textarea-artoria mb-2"></textarea>
                                        <button type="submit" class="btn-primary">
                                            Post Comment
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endauth

                    <!-- Comments List -->
                    @forelse($artwork->comments as $comment)
                        <div class="border-t border-white/10 pt-4 mt-4">
                            <div class="flex space-x-3">
                                <img src="{{ $comment->user->profile_picture_url }}" 
                                     alt="{{ $comment->user->display_name }}" 
                                     class="w-10 h-10 rounded-xl object-cover flex-shrink-0">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <div>
                                            <a href="{{ route('profile.show', $comment->user) }}" class="font-semibold text-white hover:text-artoria-400 transition-colors">
                                                {{ $comment->user->display_name }}
                                            </a>
                                            <span class="text-gray-500 text-sm ml-2">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        @can('delete', $comment)
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Delete this comment?')"
                                                        class="text-gray-400 hover:text-red-400 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                    <p class="text-gray-300">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-gray-400">No comments yet. Be the first to comment!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Artwork Info -->
                <div class="glass rounded-2xl p-6 space-y-4">
                    <h2 class="text-3xl font-bold text-white">{{ $artwork->title }}</h2>
                    
                    @if($artwork->description)
                        <p class="text-gray-300 leading-relaxed">{{ $artwork->description }}</p>
                    @endif

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 py-4 border-y border-white/10">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-artoria-400">{{ $artwork->likes_count }}</div>
                            <div class="text-sm text-gray-400">Likes</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-artoria-400">{{ $artwork->views_count }}</div>
                            <div class="text-sm text-gray-400">Views</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bolf text-artoria-400">{{ $artwork->comments->count() }}</div>
                            <div class="text-sm text-gray-400">Comments</div>
                        </div>
                    </div>

                   <!-- Category -->
                <div>
                    <span class="text-sm text-gray-400">Category:</span>
                    <a href="{{ route('artworks.by-category', $artwork->category) }}" 
                       class="badge-red ml-2">
                        {{ $artwork->category->name }}
                    </a>
                </div>

                <!-- Tags -->
                @if($artwork->tags->count() > 0)
                    <div>
                        <span class="text-sm text-gray-400 block mb-2">Tags:</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($artwork->tags as $tag)
                                <a href="{{ route('artworks.by-tag', $tag->slug) }}" class="tag">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upload Date -->
                <div class="text-sm text-gray-400">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Uploaded {{ $artwork->created_at->diffForHumans() }}
                </div>
            </div>

            <!-- Artist Card -->
            <div class="glass rounded-2xl p-6">
                <div class="text-center space-y-4">
                    <img src="{{ $artwork->user->profile_picture_url }}" 
                         alt="{{ $artwork->user->display_name }}" 
                         class="w-24 h-24 rounded-2xl object-cover mx-auto border-4 border-artoria-500/30">
                    
                    <div>
                        <a href="{{ route('profile.show', $artwork->user) }}" 
                           class="text-xl font-bold text-white hover:text-artoria-400 transition-colors block">
                            {{ $artwork->user->display_name }}
                        </a>
                        <p class="text-sm text-gray-400 capitalize">{{ $artwork->user->role }}</p>
                    </div>

                    @if($artwork->user->bio)
                        <p class="text-sm text-gray-400">{{ Str::limit($artwork->user->bio, 100) }}</p>
                    @endif

                    <a href="{{ route('profile.show', $artwork->user) }}" class="btn-secondary w-full">
                        View Profile
                    </a>

                    <!-- Social Links -->
                    @if($artwork->user->instagram_link || $artwork->user->behance_link || $artwork->user->website_link)
                        <div class="flex justify-center space-x-3 pt-4 border-t border-white/10">
                            @if($artwork->user->instagram_link)
                                <a href="{{ $artwork->user->instagram_link }}" target="_blank" class="text-gray-400 hover:text-artoria-400 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                            @endif
                            @if($artwork->user->behance_link)
                                <a href="{{ $artwork->user->behance_link }}" target="_blank" class="text-gray-400 hover:text-artoria-400 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 7h-7v-2h7v2zm1.726 10c-.442 1.297-2.029 3-5.101 3-3.074 0-5.564-1.729-5.564-5.675 0-3.91 2.325-5.92 5.466-5.92 3.082 0 4.964 1.782 5.375 4.426.078.506.109 1.188.095 2.14h-8.027c.13 3.211 3.483 3.312 4.588 2.029h3.168zm-7.686-4h4.965c-.105-1.547-1.136-2.219-2.477-2.219-1.466 0-2.277.768-2.488 2.219zm-9.574 6.988h-6.466v-14.967h6.953c5.476.081 5.58 5.444 2.72 6.906 3.461 1.26 3.577 8.061-3.207 8.061zm-3.466-8.988h3.584c2.508 0 2.906-3-.312-3h-3.272v3zm3.391 3h-3.391v3.016h3.341c3.055 0 2.868-3.016.05-3.016z"/>
                                    </svg>
                                </a>
                            @endif
                            @if($artwork->user->website_link)
                                <a href="{{ $artwork->user->website_link }}" target="_blank" class="text-gray-400 hover:text-artoria-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Challenge Participations -->
            @if($artwork->challenges->count() > 0)
                <div class="glass rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        Challenge Entries
                    </h3>
                    <div class="space-y-3">
                        @foreach($artwork->challenges as $challenge)
                            <a href="{{ route('challenges.show', $challenge) }}" 
                               class="block p-3 glass-hover rounded-xl">
                                <div class="flex items-center justify-between">
                                    <span class="text-white font-medium">{{ $challenge->title }}</span>
                                    @if($challenge->pivot->is_winner)
                                        <span class="badge-yellow">🏆 Winner</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Artworks -->
    @if($relatedArtworks->count() > 0)
        <div class="mt-16">
            <h3 class="text-3xl font-bold text-white mb-8">You might also like</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedArtworks as $related)
                    <x-artwork-card :artwork="$related" />
                @endforeach
            </div>
        </div>
    @endif
</div> 