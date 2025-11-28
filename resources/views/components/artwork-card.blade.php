@props(['artwork'])

<div class="masonry-item">
    <div class="artwork-card glass rounded-2xl overflow-hidden hover:shadow-neon-red transition-all duration-300">
        <a href="{{ route('artworks.show', $artwork) }}" class="block relative">

            <img src="{{ $artwork->image_url }}" 
                 alt="{{ $artwork->title }}" 
                 class="w-full h-auto object-cover"
                 loading="lazy">
            
            <div class="artwork-overlay">
                <div class="absolute inset-0 p-6 flex flex-col justify-between">

                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-white font-bold text-lg mb-1 line-clamp-2">{{ $artwork->title }}</h3>
                            <p class="text-gray-300 text-sm line-clamp-2">{{ $artwork->description }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
\
                        @if($artwork->tags->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($artwork->tags->take(3) as $tag)
                                    <span class="tag text-xs">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                                @if($artwork->tags->count() > 3)
                                    <span class="tag text-xs">
                                        +{{ $artwork->tags->count() - 3 }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-300">
                                <span class="flex items-center space-x-1">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $artwork->likes_count }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>{{ $artwork->views_count }}</span>
                                </span>
                            </div>

                            <span class="badge-red text-xs">
                                {{ $artwork->category->name }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-3 pt-3 border-t border-white/10">
                            <img src="{{ $artwork->user->profile_picture_url }}" 
                                 alt="{{ $artwork->user->display_name }}" 
                                 class="w-8 h-8 rounded-lg object-cover">
                            <div>
                                <p class="text-white text-sm font-medium">{{ $artwork->user->display_name }}</p>
                                <p class="text-gray-400 text-xs">{{ $artwork->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>