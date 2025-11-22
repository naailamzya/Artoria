<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Profile Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center gap-6">
                        <!-- Profile Photo -->
                        <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center overflow-hidden">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl font-bold text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>

                        <!-- Profile Info -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                            
                            <!-- Status Badge -->
                            <div class="mt-2">
                                @if($user->status === 'admin')
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                        👑 Admin
                                    </span>
                                @elseif($user->status === 'curator')
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                        🏆 Curator
                                    </span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                        🎨 Member
                                    </span>
                                @endif
                            </div>

                            <!-- Bio -->
                            @if($user->bio)
                                <p class="text-gray-700 mt-4">{{ $user->bio }}</p>
                            @endif

                            <!-- External Link -->
                            @if($user->external_link)
                                <a href="{{ $user->external_link }}" target="_blank" 
                                    class="text-blue-600 hover:underline mt-2 inline-block">
                                    🔗 {{ $user->external_link }}
                                </a>
                            @endif

                            <!-- Stats -->
                            <div class="flex gap-6 mt-4 text-gray-600">
                                <span>🎨 {{ $user->artworks->count() }} Artworks</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User's Artworks -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Artworks</h2>

                    @if($user->artworks->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($user->artworks as $artwork)
                                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <a href="{{ route('artworks.show', $artwork->id) }}">
                                        <img src="{{ asset('storage/' . $artwork->file_path) }}" 
                                            alt="{{ $artwork->title }}" 
                                            class="w-full h-48 object-cover">
                                    </a>
                                    <div class="p-4">
                                        <a href="{{ route('artworks.show', $artwork->id) }}" 
                                            class="font-semibold text-gray-900 hover:text-blue-600">
                                            {{ $artwork->title }}
                                        </a>
                                        <p class="text-sm text-gray-600">{{ $artwork->category->name }}</p>
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                            <span>❤️ {{ $artwork->likes->count() }}</span>
                                            <span>💬 {{ $artwork->comments->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">This user hasn't uploaded any artworks yet.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>