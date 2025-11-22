<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Artwork Image -->
                        <div>
                            <img src="{{ asset('storage/' . $artwork->file_path) }}" 
                                alt="{{ $artwork->title }}" 
                                class="w-full rounded-lg shadow-lg">
                        </div>

                        <!-- Artwork Info -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $artwork->title }}</h1>
                            
                            <!-- Creator Info -->
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                    @if($artwork->user->profile_photo)
                                        <img src="{{ asset('storage/' . $artwork->user->profile_photo) }}" 
                                            class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <span class="text-xl font-bold text-gray-600">{{ substr($artwork->user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('profile.show', $artwork->user->id) }}" 
                                        class="font-semibold text-gray-900 hover:text-blue-600">
                                        {{ $artwork->user->name }}
                                    </a>
                                    <p class="text-sm text-gray-500">{{ $artwork->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="mb-6">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $artwork->category->name }}
                                </span>
                            </div>

                            <!-- Description -->
                            @if($artwork->description)
                                <div class="mb-6">
                                    <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                                    <p class="text-gray-700">{{ $artwork->description }}</p>
                                </div>
                            @endif

                            <!-- Stats -->
                            <div class="flex items-center gap-6 mb-6 text-gray-600">
                                <span>❤️ {{ $artwork->likes->count() }} Likes</span>
                                <span>💬 {{ $artwork->comments->count() }} Comments</span>
                            </div>

                            <!-- Actions -->
                            @auth
                                <div class="flex gap-4 mb-6">
                                    <!-- Like Button -->
                                    <form action="{{ route('artworks.like', $artwork->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                            {{ $hasLiked ? '❤️ Liked' : '🤍 Like' }}
                                        </button>
                                    </form>

                                    <!-- Favorite Button -->
                                    <form action="{{ route('artworks.favorite', $artwork->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                                            {{ $hasFavorited ? '⭐ Saved' : '☆ Save' }}
                                        </button>
                                    </form>

                                    <!-- Report Button -->
                                    @if(Auth::id() !== $artwork->user_id)
                                        <a href="{{ route('reports.create', $artwork->id) }}" 
                                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                            🚨 Report
                                        </a>
                                    @endif
                                </div>
                            @else
                                <p class="text-gray-600 mb-6">
                                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a> to like, save, or comment on this artwork.
                                </p>
                            @endauth

                            <!-- Edit/Delete (Owner Only) -->
                            @auth
                                @if(Auth::id() === $artwork->user_id)
                                    <div class="flex gap-4 pt-4 border-t">
                                        <a href="{{ route('artworks.edit', $artwork->id) }}" 
                                            class="text-green-600 hover:underline font-semibold">Edit</a>
                                        <form action="{{ route('artworks.destroy', $artwork->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this artwork?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline font-semibold">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="mt-12 border-t pt-8">
                        <h2 class="text-2xl font-bold mb-6">Comments ({{ $artwork->comments->count() }})</h2>

                        <!-- Comment Form -->
                        @auth
                            <form action="{{ route('comments.store', $artwork->id) }}" method="POST" class="mb-8">
                                @csrf
                                <textarea name="comment" rows="3" placeholder="Write a comment..." 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required></textarea>
                                @error('comment')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Post Comment
                                </button>
                            </form>
                        @endauth

                        <!-- Comments List -->
                        @if($artwork->comments->count() > 0)
                            <div class="space-y-4">
                                @foreach($artwork->comments as $comment)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-gray-600">{{ substr($comment->user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $comment->user->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            
                                            @auth
                                                @if(Auth::id() === $comment->user_id)
                                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                        onsubmit="return confirm('Delete this comment?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                        <p class="text-gray-700 mt-2">{{ $comment->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>