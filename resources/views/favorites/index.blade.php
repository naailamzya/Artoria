<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Favorites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    @if($favorites->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($favorites as $favorite)
                                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <a href="{{ route('artworks.show', $favorite->artwork->id) }}">
                                        <img src="{{ asset('storage/' . $favorite->artwork->file_path) }}" 
                                            alt="{{ $favorite->artwork->title }}" 
                                            class="w-full h-48 object-cover">
                                    </a>
                                    <div class="p-4">
                                        <a href="{{ route('artworks.show', $favorite->artwork->id) }}" 
                                            class="font-semibold text-gray-900 hover:text-blue-600">
                                            {{ $favorite->artwork->title }}
                                        </a>
                                        <p class="text-sm text-gray-600 mt-1">
                                            by <a href="{{ route('profile.show', $favorite->artwork->user->id) }}" 
                                                class="text-blue-600 hover:underline">
                                                {{ $favorite->artwork->user->name }}
                                            </a>
                                        </p>
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                            <span>❤️ {{ $favorite->artwork->likes->count() }}</span>
                                            <span>💬 {{ $favorite->artwork->comments->count() }}</span>
                                        </div>
                                        
                                        <!-- Remove from favorites -->
                                        <form action="{{ route('artworks.favorite', $favorite->artwork->id) }}" method="POST" class="mt-3">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:underline text-sm">
                                                Remove from favorites
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $favorites->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">You haven't saved any artworks yet.</p>
                            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Browse artworks →</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>