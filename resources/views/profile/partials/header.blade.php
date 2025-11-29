<div class="p-8 md:p-10">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">

        <!-- Profile Picture -->
        <div class="flex-shrink-0">
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                     alt="{{ $user->name }}" 
                     class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover ring-4 ring-artoria-500/30 shadow-xl">
            @else
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-gradient-to-br from-artoria-500 to-pink-500 flex items-center justify-center ring-4 ring-artoria-500/30 shadow-xl">
                    <span class="text-5xl md:text-6xl text-white font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
            @endif
        </div>

        <!-- User Info & Stats -->
        <div class="flex-grow w-full text-center md:text-left">
            <!-- Name & Email -->
            <div class="mb-6">
                <h1 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">
                    {{ $user->name }}
                </h1>
                <p class="text-gray-400 mb-3">{{ $user->email }}</p>

                <p class="text-gray-300 leading-relaxed max-w-2xl mx-auto md:mx-0">
                    {{ $user->bio ?? 'This user has no bio yet.' }}
                </p>
            </div>

            <!-- Stats Grid -->
            @if(isset($stats) && is_array($stats))
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300">
                        <div class="font-bold text-2xl md:text-3xl gradient-text">{{ $stats['artworks_count'] ?? 0 }}</div>
                        <div class="text-gray-400 text-xs md:text-sm mt-1">Artworks</div>
                    </div>
                    <div class="p-4 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300">
                        <div class="font-bold text-2xl md:text-3xl gradient-text">{{ $stats['total_likes'] ?? 0 }}</div>
                        <div class="text-gray-400 text-xs md:text-sm mt-1">Likes</div>
                    </div>
                    <div class="p-4 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300">
                        <div class="font-bold text-2xl md:text-3xl gradient-text">{{ $stats['total_views'] ?? 0 }}</div>
                        <div class="text-gray-400 text-xs md:text-sm mt-1">Views</div>
                    </div>
                    <div class="p-4 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all duration-300">
                        <div class="font-bold text-2xl md:text-3xl gradient-text">{{ $stats['favorites_count'] ?? 0 }}</div>
                        <div class="text-gray-400 text-xs md:text-sm mt-1">Favorites</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Edit Button (Desktop) -->
        @auth
            @if(auth()->id() === $user->id)
                <div class="flex-shrink-0 hidden md:block">
                    <a href="{{ route('profile.edit') }}" 
                       class="btn-secondary px-6 py-3 inline-flex items-center space-x-2 whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Profile</span>
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Edit Button (Mobile) -->
    @auth
        @if(auth()->id() === $user->id)
            <div class="mt-6 md:hidden">
                <a href="{{ route('profile.edit') }}" 
                   class="btn-secondary w-full px-6 py-3 inline-flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Edit Profile</span>
                </a>
            </div>
        @endif
    @endauth
</div>