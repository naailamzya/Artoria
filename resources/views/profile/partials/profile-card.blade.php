<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <div class="flex items-center space-x-4">

            <!-- Profile Picture -->
            <div class="flex-shrink-0">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                         alt="{{ $user->name }}" 
                         class="w-24 h-24 rounded-full object-cover">
                @else
                    <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-3xl text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>

            <!-- User Info -->
            <div class="flex-grow">
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-gray-600">{{ $user->email }}</p>

                <p class="mt-2 text-gray-700">
                    {{ $user->bio ?? 'This user has no bio yet.' }}
                </p>

                <!-- Stats -->
                @if(isset($stats) && is_array($stats))
                    <div class="flex space-x-6 mt-4">
                        <div>
                            <span class="font-bold text-lg">{{ $stats['artworks_count'] ?? 0 }}</span>
                            <span class="text-gray-600 text-sm">Artworks</span>
                        </div>
                        <div>
                            <span class="font-bold text-lg">{{ $stats['total_likes'] ?? 0 }}</span>
                            <span class="text-gray-600 text-sm">Likes</span>
                        </div>
                        <div>
                            <span class="font-bold text-lg">{{ $stats['total_views'] ?? 0 }}</span>
                            <span class="text-gray-600 text-sm">Views</span>
                        </div>
                        <div>
                            <span class="font-bold text-lg">{{ $stats['favorites_count'] ?? 0 }}</span>
                            <span class="text-gray-600 text-sm">Favorites</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Edit Button -->
            @auth
                @if(auth()->id() === $user->id)
                    <div>
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md text-white text-xs font-semibold hover:bg-gray-700">
                            Edit Profile
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
