@props(['challenge'])

<div class="glass rounded-2xl overflow-hidden hover:shadow-neon-red transition-all duration-300 group">
    <a href="{{ route('challenges.show', $challenge) }}" class="block">

        <div class="relative h-48 overflow-hidden">
            <img src="{{ $challenge->banner_url }}" 
                 alt="{{ $challenge->title }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            
            <div class="absolute top-4 right-4">
                @if($challenge->isActive())
                    <span class="badge-green backdrop-blur-xl">
                        🔥 Active
                    </span>
                @elseif($challenge->hasEnded())
                    <span class="badge-red backdrop-blur-xl">
                        🏁 Ended
                    </span>
                @else
                    <span class="badge-blue backdrop-blur-xl">
                        ⏰ Upcoming
                    </span>
                @endif
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        </div>

        <div class="p-6 space-y-4">
            <h3 class="text-xl font-bold text-white group-hover:text-artoria-400 transition-colors duration-300 line-clamp-2">
                {{ $challenge->title }}
            </h3>

            <p class="text-gray-400 text-sm line-clamp-3">
                {{ $challenge->description }}
            </p>

            <div class="flex items-center space-x-6 text-sm">
                <div class="flex items-center space-x-2 text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>{{ $challenge->entries_count ?? 0 }} entries</span>
                </div>

                <div class="flex items-center space-x-2 text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $challenge->end_date->diffForHumans() }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-white/10">
                <div class="flex items-center space-x-3">
                    <img src="{{ $challenge->curator->profile_picture_url }}" 
                         alt="{{ $challenge->curator->display_name }}" 
                         class="w-8 h-8 rounded-lg object-cover">
                    <div>
                        <p class="text-white text-sm font-medium">{{ $challenge->curator->display_name }}</p>
                        <p class="text-gray-400 text-xs">Curator</p>
                    </div>
                </div>

                @if($challenge->prizes)
                    <div class="text-right">
                        <p class="text-artoria-400 text-sm font-semibold">🏆 Prizes</p>
                        <p class="text-gray-400 text-xs">Available</p>
                    </div>
                @endif
            </div>
        </div>
    </a>
</div>