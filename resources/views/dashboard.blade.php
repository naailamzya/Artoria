<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-gray-600 text-sm font-semibold">Total Artworks</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalArtworks }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-gray-600 text-sm font-semibold">Total Likes</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalLikes }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-gray-600 text-sm font-semibold">Total Comments</h3>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalComments }}</p>
                    </div>
                </div>
            </div>

            <!-- Upload Button -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <a href="{{ route('artworks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded inline-block">
                        + Upload New Artwork
                    </a>
                </div>
            </div>

            <!-- My Artworks -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">My Artworks</h2>

                    @if($myArtworks->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($myArtworks as $artwork)
                                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <img src="{{ asset('storage/' . $artwork->file_path) }}" 
                                        alt="{{ $artwork->title }}" 
                                        class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900">{{ $artwork->title }}</h3>
                                        <p class="text-sm text-gray-600">{{ $artwork->category->name }}</p>
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                            <span>❤️ {{ $artwork->likes->count() }}</span>
                                            <span>💬 {{ $artwork->comments->count() }}</span>
                                        </div>
                                        <div class="mt-4 flex gap-2">
                                            <a href="{{ route('artworks.show', $artwork->id) }}" 
                                                class="text-blue-600 hover:underline text-sm">View</a>
                                            <a href="{{ route('artworks.edit', $artwork->id) }}" 
                                                class="text-green-600 hover:underline text-sm">Edit</a>
                                            <form action="{{ route('artworks.destroy', $artwork->id) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this artwork?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">You haven't uploaded any artworks yet.</p>
                            <a href="{{ route('artworks.create') }}" class="text-blue-600 hover:underline">Upload your first artwork →</a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>