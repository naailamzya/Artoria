@props(['artwork'])

<div class="artwork-card glass rounded-2xl overflow-hidden hover:shadow-neon-red transition-all duration-300 h-full">
    <a href="{{ route('artworks.show', $artwork) }}" class="block relative group">
        <!-- Image -->
        <div class="relative overflow-hidden">
            <img src="{{ $artwork->image_url }}" 
                 alt="{{ $artwork->title }}" 
                 class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300"
                 loading="lazy">
            
            <!-- Overlay - muncul saat hover -->
            <div class="artwork-overlay absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute inset-0 p-4 flex flex-col justify-end">
                    <!-- Title & Description -->
                    <div class="mb-3">
                        <h3 class="text-white font-bold text-lg mb-1 line-clamp-1">{{ $artwork->title }}</h3>
                        @if($artwork->description)
                            <p class="text-gray-300 text-sm line-clamp-2">{{ $artwork->description }}</p>
                        @endif
                    </div>

                    <!-- Tags -->
                    @if($artwork->tags && $artwork->tags->count() > 0)
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach($artwork->tags->take(3) as $tag)
                                <span class="tag text-xs px-2 py-1">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                            @if($artwork->tags->count() > 3)
                                <span class="tag text-xs px-2 py-1">
                                    +{{ $artwork->tags->count() - 3 }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <!-- Stats & Category -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-3 text-sm text-white">
                            <span class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ number_format($artwork->likes_count ?? 0) }}</span>
                            </span>
                            <span class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>{{ number_format($artwork->views_count ?? 0) }}</span>
                            </span>
                        </div>

                        @if($artwork->category)
                            <span class="badge-red text-xs px-2 py-1">
                                {{ $artwork->category->name }}
                            </span>
                        @endif
                    </div>

                    <!-- User Info -->
                    <div class="flex items-center space-x-2">
                        <img src="{{ $artwork->user->profile_picture_url }}" 
                             alt="{{ $artwork->user->display_name ?? $artwork->user->name }}" 
                             class="w-7 h-7 rounded-full object-cover border-2 border-white/20">
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-sm font-medium truncate">{{ $artwork->user->display_name ?? $artwork->user->name }}</p>
                            <p class="text-gray-300 text-xs">{{ $artwork->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>