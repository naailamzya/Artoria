@extends('layouts.app')

@section('title', $challenge->title)

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Banner Section -->
        <div class="relative h-96 rounded-3xl overflow-hidden mb-8">
            <img src="{{ $challenge->banner_url }}" 
                 alt="{{ $challenge->title }}" 
                 class="w-full h-full object-cover">
            
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
            
            <!-- Content -->
            <div class="absolute inset-0 flex flex-col justify-end p-8">
                <!-- Status Badge -->
                <div class="mb-4">
                    @if($challenge->isActive())
                        <span class="badge-green backdrop-blur-xl text-lg px-4 py-2">
                            🔥 Active Challenge
                        </span>
                    @elseif($challenge->hasEnded())
                        <span class="badge-red backdrop-blur-xl text-lg px-4 py-2">
                            🏁 Challenge Ended
                        </span>
                    @else
                        <span class="badge-blue backdrop-blur-xl text-lg px-4 py-2">
                            ⏰ Coming Soon
                        </span>
                    @endif
                </div>
                
                <h1 class="text-4xl md:text-6xl font-display font-bold text-white mb-4 text-shadow-lg">
                    {{ $challenge->title }}
                </h1>
                
                <!-- Meta Info -->
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
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                <div class="glass rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        About This Challenge
                    </h2>
                    <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $challenge->description }}</p>
                </div>

                <!-- Rules -->
                @if($challenge->rules)
                    <div class="glass rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Rules & Guidelines
                        </h2>
                        <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $challenge->rules }}</p>
                    </div>
                @endif

                <!-- Prizes -->
                @if($challenge->prizes)
                    <div class="glass rounded-2xl p-8 border-2 border-yellow-500/30">
                        <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                            Prizes
                        </h2>
                        <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $challenge->prizes }}</p>
                    </div>
                @endif

                <!-- Winners (If Ended) -->
                @if($winners->count() > 0)
                    <div class="glass rounded-2xl p-8 border-2 border-artoria-500/30">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                            🏆 Winners
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($winners as $winner)
                                <div class="glass-hover rounded-xl p-4 border-2 border-yellow-500/20">
                                    <a href="{{ route('artworks.show', $winner->artwork) }}" class="block">
                                        <img src="{{ $winner->artwork->image_url }}" 
                                             alt="{{ $winner->artwork->title }}" 
                                             class="w-full h-48 object-cover rounded-lg mb-3">
                                        <h3 class="text-white font-bold mb-1">{{ $winner->artwork->title }}</h3>
                                        <p class="text-sm text-gray-400">by {{ $winner->artwork->user->display_name }}</p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Entries -->
                <div class="glass rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        All Entries ({{ $entries->total() }})
                    </h2>

                    @if($entries->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            @foreach($entries as $entry)
                                <x-artwork-card :artwork="$entry->artwork" />
                            @endforeach
                        </div>

                        <!-- Pagination -->
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
                <!-- Submit Button -->
                @auth
                    @if(auth()->user()->isMember() || auth()->user()->isCurator())
                        @if($challenge->canAcceptSubmissions())
                            <div class="glass rounded-2xl p-6">
                                @if($hasSubmitted)
                                    <div class="text-center space-y-4">
                                        <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto">
                                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-white">You're Participating!</h3>
                                        <p class="text-gray-400">Your entry has been submitted</p>
                                        <a href="{{ route('artworks.show', $userEntry->artwork) }}" class="btn-secondary w-full">
                                            View Your Entry
                                        </a>
                                    </div>
                                @else
                                    <h3 class="text-xl font-bold text-white mb-4">Ready to Compete?</h3>
                                    <p class="text-gray-400 text-sm mb-4">Submit your artwork to this challenge</p>
                                    <button @click="$dispatch('submit-modal')" class="btn-primary w-full">
                                        Submit Your Work
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="glass rounded-2xl p-6 border-2 border-red-500/30">
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
                        <p class="text-gray-400 text-sm mb-4">Login to submit your artwork</p>
                        <div class="space-y-2">
                            <a href="{{ route('login') }}" class="btn-primary w-full text-center block">Login</a>
                            <a href="{{ route('register') }}" class="btn-secondary w-full text-center block">Sign Up</a>
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

                <!-- Stats -->
                <div class="glass rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Total Entries</span>
                            <span class="text-white font-semibold">{{ $entries->total() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Participants</span>
                            <span class="text-white font-semibold">{{ $entries->pluck('user_id')->unique()->count() }}</span>
                        </div>
                        @if($winners->count() > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Winners</span>
                                <span class="text-yellow-400 font-semibold">{{ $winners->count() }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit Modal -->
@auth
    @if((auth()->user()->isMember() || auth()->user()->isCurator()) && $challenge->canAcceptSubmissions() && !$hasSubmitted)
        <div x-data="{ show: false }" 
             @submit-modal.window="show = true"
             x-show="show"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             style="display: none;">
            
            <!-- Backdrop -->
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="show" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="show = false"
                     class="fixed inset-0 transition-opacity bg-black/80 backdrop-blur-sm"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <!-- Modal Content -->
                <div x-show="show" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom glass border border-white/10 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <form action="{{ route('challenges.submit', $challenge) }}" method="POST" class="p-6">
                        @csrf
                        
                        <h3 class="text-2xl font-bold text-white mb-4">Submit to Challenge</h3>
                        <p class="text-gray-400 mb-6">Select an artwork from your portfolio to submit</p>

                        <select name="artwork_id" required class="input-artoria mb-6">
                            <option value="">Choose an artwork...</option>
                            @foreach(auth()->user()->artworks as $artwork)
                                <option value="{{ $artwork->id }}">{{ $artwork->title }}</option>
                            @endforeach
                        </select>

                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 btn-primary">
                                Submit Entry
                            </button>
                            <button type="button" @click="show = false" class="flex-1 btn-secondary">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endauth
@endsection