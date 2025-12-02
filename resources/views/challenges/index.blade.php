@extends('layouts.app')

@section('title', 'Challenges')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-display font-bold text-white mb-4">
                Art <span class="gradient-text neon-text">Challenges</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Compete with talented artists, showcase your skills, and win amazing prizes!
            </p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex justify-center mb-8">
            <div class="glass rounded-2xl p-2 inline-flex space-x-2">
                <a href="{{ route('challenges.index', ['filter' => 'active']) }}" 
                   class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'active' ? 'bg-gradient-to-r from-artoria-500 to-artoria-600 text-white shadow-neon-red' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    Active
                </a>
                <a href="{{ route('challenges.index', ['filter' => 'upcoming']) }}" 
                   class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'upcoming' ? 'bg-gradient-to-r from-artoria-500 to-artoria-600 text-white shadow-neon-red' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    Upcoming
                </a>
                <a href="{{ route('challenges.index', ['filter' => 'ended']) }}" 
                   class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'ended' ? 'bg-gradient-to-r from-artoria-500 to-artoria-600 text-white shadow-neon-red' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    Ended
                </a>
            </div>
        </div>

        <!-- Challenges Grid -->
        @if($challenges->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach($challenges as $challenge)
                    <x-challenge-card :challenge="$challenge" />
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $challenges->appends(['filter' => $filter])->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-full flex items-center justify-center animate-pulse-slow">
                    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">
                    @if($filter === 'active')
                        No active challenges right now
                    @elseif($filter === 'upcoming')
                        No upcoming challenges scheduled
                    @else
                        No ended challenges yet
                    @endif
                </h3>
                <p class="text-gray-400 mb-6">Check back soon for new challenges!</p>
                <a href="{{ route('challenges.index') }}" class="btn-secondary">View All Challenges</a>
            </div>
        @endif

        @auth
            @if(auth()->user()->isCurator() && auth()->user()->isActive())
                <div class="mt-16 glass rounded-3xl p-12 text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-artoria-500/20 to-pink-500/20"></div>
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold text-white mb-4">
                            Want to Create a Challenge?
                        </h2>
                        <p class="text-gray-300 mb-6">
                            As a curator, you can create exciting challenges for the community!
                        </p>
                        <a href="{{ route('curator.challenges.create') }}" class="btn-primary inline-flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Create Challenge</span>
                        </a>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection