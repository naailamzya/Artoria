<div class="glass rounded-3xl p-8 mb-6 animate-fade-in-up animation-delay-200">
    <h2 class="text-2xl font-display font-bold text-white mb-6 flex items-center space-x-2">
        <svg class="w-6 h-6 text-artoria-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        <span>Profile Stats</span>
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="text-center p-4 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all">
            <div class="font-bold text-3xl gradient-text">{{ $stats['artworks_count'] ?? 0 }}</div>
            <div class="text-gray-400 text-sm mt-1">Artworks</div>
        </div>
        <div class="text-center p-4 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all">
            <div class="font-bold text-3xl gradient-text">{{ $stats['total_likes'] ?? 0 }}</div>
            <div class="text-gray-400 text-sm mt-1">Likes</div>
        </div>
        <div class="text-center p-4 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all">
            <div class="font-bold text-3xl gradient-text">{{ $stats['total_views'] ?? 0 }}</div>
            <div class="text-gray-400 text-sm mt-1">Views</div>
        </div>
        <div class="text-center p-4 bg-dark-700/50 rounded-xl border border-white/5 hover:border-artoria-500/30 transition-all">
            <div class="font-bold text-3xl gradient-text">{{ $stats['favorites_count'] ?? 0 }}</div>
            <div class="text-gray-400 text-sm mt-1">Favorites</div>
        </div>
    </div>
</div>