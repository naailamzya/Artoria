@extends('layouts.app')

@section('title', $challenge->title)

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <div class="relative h-64 md:h-96 rounded-3xl overflow-hidden mb-8">
            <img src="{{ $challenge->banner_url }}" 
                 alt="{{ $challenge->title }}" 
                 class="w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
            
            <div class="absolute inset-0 flex flex-col justify-end p-8">
                <div class="mb-4">
                    @if($challenge->isActive())
                        <span class="badge-green">
                            Active Challenge
                        </span>
                    @elseif($challenge->hasEnded())
                        <span class="badge-red">
                            Challenge Ended
                        </span>
                    @else
                        <span class="badge-blue">
                            Coming Soon
                        </span>
                    @endif
                </div>
                
                <h1 class="text-3xl md:text-6xl font-display font-bold text-white mb-4">
                    {{ $challenge->title }}
                </h1>
                
                <div class="flex flex-wrap gap-6 text-white/90">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>by {{ $challenge->curator->display_name }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>{{ $entries->total() }} Entries</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Ends {{ $challenge->end_date->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="glass rounded-2xl p-6">
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        About This Challenge
                    </h2>
                    <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $challenge->description }}</p>
                </div>

                @if($challenge->rules)
                    <div class="glass rounded-2xl p-6">
                        <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Rules & Guidelines
                        </h2>
                        <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $challenge->rules }}</p>
                    </div>
                @endif

                <div class="glass rounded-2xl p-6">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        All Entries ({{ $entries->total() }})
                    </h2>

                    @if($entries->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            @foreach($entries as $entry)
                                <x-artwork-card :artwork="$entry" />
                            @endforeach
                        </div>
                        <div class="flex justify-center">
                            {{ $entries->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-400">No entries yet. Be the first to participate!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                @auth
                    @if(auth()->user()->isMember() || auth()->user()->isCurator())
                        @if($challenge->canAcceptSubmissions())
                            @if($hasSubmitted)
                                <div class="glass rounded-2xl p-6 border border-green-500/30">
                                    <div class="text-center space-y-4">
                                        <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto">
                                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-white">You're Participating!</h3>
                                        <p class="text-gray-400">Your entry has been submitted</p>
                                        @if($userEntries->first())
                                            <a href="{{ route('artworks.show', $userEntries->first()) }}" 
                                               class="btn-secondary w-full">
                                                View Your Entry
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <!-- DIRECT SUBMIT FORM -->
                                <div class="glass rounded-2xl p-6">
                                    <h3 class="text-xl font-bold text-white mb-4">Ready to Compete?</h3>
                                    <p class="text-gray-400 text-sm mb-6">Submit your artwork to this challenge</p>
                                    
                                    @php
                                        $userArtworks = auth()->user()->artworks ?? collect();
                                    @endphp
                                    
                                    @if($userArtworks->count() > 0)
                                        <form action="{{ route('challenges.submit', $challenge) }}" method="POST" 
                                              class="space-y-4">
                                            @csrf
                                            
                                            <div>
                                                <label class="block text-gray-300 mb-2">Select Your Artwork</label>
                                                <select name="artwork_id" required 
                                                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-artoria-500 focus:ring-2 focus:ring-artoria-500/50">
                                                    <option value="">Choose an artwork...</option>
                                                    @foreach($userArtworks as $artwork)
                                                        <option value="{{ $artwork->id }}">{{ $artwork->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <button type="submit" 
                                                    class="btn-primary w-full">
                                                Submit Your Work
                                            </button>
                                            
                                            <div class="text-center">
                                                <a href="{{ route('artworks.create') }}" 
                                                   class="text-artoria-400 hover:text-artoria-300 text-sm">
                                                    Don't have artwork? Create one first
                                                </a>
                                            </div>
                                        </form>
                                    @else
                                        <div class="text-center py-6">
                                            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-gray-300 mb-6">You need to create an artwork first</p>
                                            <a href="{{ route('artworks.create') }}" 
                                               class="btn-primary w-full">
                                                 Create Artwork
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="glass rounded-2xl p-6 border border-red-500/30">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold text-white mb-2">Submissions Closed</h3>
                                    <p class="text-gray-400 text-sm">This challenge is no longer accepting entries</p>
                                </div>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="glass rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-4">Want to Participate?</h3>
                        <p class="text-gray-400 text-sm mb-6">Login to submit your artwork</p>
                        <div class="space-y-3">
                            <a href="{{ route('login') }}" 
                               class="btn-primary w-full text-center block">
                                Login
                            </a>
                            <a href="{{ route('register') }}" 
                               class="btn-secondary w-full text-center block">
                                Sign Up
                            </a>
                        </div>
                    </div>
                @endauth

                <!-- Timeline -->
                <div class="glass rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Timeline
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-400">Starts</p>
                            <p class="text-white font-semibold">{{ $challenge->start_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Ends</p>
                            <p class="text-white font-semibold">{{ $challenge->end_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Duration</p>
                            <p class="text-white font-semibold">{{ $challenge->start_date->diffInDays($challenge->end_date) }} days</p>
                        </div>
                    </div>
                </div>

                <!-- Curator Info -->
                <div class="glass rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Curator</h3>
                    <div class="flex items-center space-x-3">
                        <img src="{{ $challenge->curator->profile_picture_url }}" 
                             alt="{{ $challenge->curator->display_name }}" 
                             class="w-12 h-12 rounded-xl object-cover">
                        <div class="flex-1">
                            <a href="{{ route('profile.show', $challenge->curator) }}" 
                               class="text-white font-semibold hover:text-artoria-400 transition-colors block">
                                {{ $challenge->curator->display_name }}
                            </a>
                            <p class="text-sm text-gray-400">Challenge Creator</p>
                        </div>
                    </div>
                </div>

                <!-- Curator Management Section -->
                @if(auth()->user()?->isCurator() && auth()->user()->id === $challenge->curator_id)
                    <div class="glass rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Manage Challenge
                        </h3>

                        <!-- Winner Selection Section -->
                        @if($challenge->hasEnded() && $entries->count() > 0)
                            <div class="mb-4">
                                <p class="text-sm text-gray-400 mb-3">Select Winner</p>
                                <form action="{{ route('curator.challenges.select-winner', [$challenge, $entries->first()]) }}" method="POST" class="space-y-3" id="winner-form">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <select name="entry_id" required 
                                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-artoria-500 focus:ring-2 focus:ring-artoria-500/50">
                                        <option value="">Choose winner...</option>
                                        @foreach($entries as $entry)
                                            <option value="{{ $entry->id }}" 
                                                    {{ $entry->is_winner ? 'selected' : '' }}>
                                                {{ $entry->artwork?->title ?? 'Unknown Artwork' }} by {{ $entry->user->display_name }}
                                                {{ $entry->is_winner ? '(WINNER)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <button type="submit" class="btn-primary w-full" 
                                            onclick="return confirm('Are you sure you want to set this as the winner?')">
                                        Set Winner
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- Display Current Winners -->
                        @php
                            $winners = $challenge->entries()->where('is_winner', true)->with('artwork.user')->get();
                        @endphp
                        @if($winners->count() > 0)
                            <div class="border-t border-gray-700 pt-4 mt-4">
                                <p class="text-sm text-gray-400 mb-2">🏆 Current Winner{{ $winners->count() > 1 ? 's' : '' }}</p>
                                @foreach($winners as $winner)
                                    <div class="bg-gradient-to-r from-yellow-500/10 to-yellow-600/10 border border-yellow-500/30 rounded-lg p-3 mb-2 last:mb-0">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-white text-sm font-semibold">{{ $winner->artwork?->title ?? 'Unknown Artwork' }}</p>
                                                <p class="text-gray-300 text-xs">by {{ $winner->user->display_name }}</p>
                                            </div>
                                            <form action="{{ route('curator.challenges.remove-winner', [$challenge, $winner]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-400 hover:text-red-300 text-xs" onclick="return confirm('Are you sure you want to remove this winner?')">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Entries Management Link -->
                        <div class="border-t border-gray-700 pt-4 mt-4">
                            <a href="{{ route('curator.challenges.entries', $challenge) }}" 
                               class="btn-secondary w-full text-center block">
                                View All Entries
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<style>
button, .btn-primary, .btn-secondary, a[href]:not([href="#"]):not([href="javascript:void(0)"]),
input[type="submit"], input[type="button"] {
    cursor: pointer !important;
    pointer-events: auto !important;
    position: relative;
    z-index: 10;
}

.glass {
    position: relative;
    z-index: 1;
}

.btn-primary:hover, .btn-secondary:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('button, .btn-primary, a.btn');
    console.log('Found', buttons.length, 'buttons on page');
    
    buttons.forEach(btn => {
        if (!btn.hasAttribute('onclick')) {
            btn.addEventListener('click', function(e) {
                console.log('Button clicked:', this.textContent.trim());
            });
        }
    });
});
</script>
@endsection