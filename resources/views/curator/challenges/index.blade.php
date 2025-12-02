@extends('layouts.app')

@section('title', 'My Challenges')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                    My Challenges
                </h1>
                <p class="text-gray-400">Manage all your challenges in one place</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('curator.challenges.create') }}" class="btn-primary inline-flex items-center space-x-2 px-6 py-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Create New Challenge</span>
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="glass rounded-2xl p-2 mb-8 inline-flex space-x-2">
            <a href="{{ route('curator.challenges.mine') }}" 
               class="px-6 py-3 rounded-xl {{ !request('status') ? 'bg-artoria-500 text-white' : 'text-gray-400 hover:text-white' }} transition-all font-semibold">
                All
            </a>
            <a href="{{ route('curator.challenges.mine', ['status' => 'active']) }}" 
               class="px-6 py-3 rounded-xl {{ request('status') === 'active' ? 'bg-green-500 text-white' : 'text-gray-400 hover:text-white' }} transition-all font-semibold">
                Active
            </a>
            <a href="{{ route('curator.challenges.mine', ['status' => 'draft']) }}" 
               class="px-6 py-3 rounded-xl {{ request('status') === 'draft' ? 'bg-yellow-500 text-white' : 'text-gray-400 hover:text-white' }} transition-all font-semibold">
                Draft
            </a>
            <a href="{{ route('curator.challenges.mine', ['status' => 'ended']) }}" 
               class="px-6 py-3 rounded-xl {{ request('status') === 'ended' ? 'bg-gray-500 text-white' : 'text-gray-400 hover:text-white' }} transition-all font-semibold">
                Ended
            </a>
        </div>

        <!-- Challenges Grid -->
        @if($challenges->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($challenges as $challenge)
                    <div class="glass rounded-2xl overflow-hidden hover:scale-105 hover:shadow-neon-red transition-all duration-300 group">
                        <!-- Banner -->
                        <div class="relative h-48">
                            @if($challenge->banner_image)
                                <img src="{{ $challenge->banner_url }}" 
                                     alt="{{ $challenge->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-artoria-500/20 to-pink-500/20 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            <div class="absolute top-4 right-4">
                                @if($challenge->status === 'active')
                                    <span class="badge-green backdrop-blur-xl"> Active</span>
                                @elseif($challenge->status === 'draft')
                                    <span class="badge-yellow backdrop-blur-xl"> Draft</span>
                                @elseif($challenge->status === 'ended')
                                    <span class="badge-gray backdrop-blur-xl"> Ended</span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-artoria-400 transition-colors line-clamp-1">
                                {{ $challenge->title }}
                            </h3>
                            
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ $challenge->description }}
                            </p>

                            <!-- Stats -->
                            <div class="flex items-center space-x-4 text-sm text-gray-400 mb-4 pb-4 border-b border-white/10">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $challenge->entries_count ?? 0 }}</span>
                                </div>
                                <span>•</span>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $challenge->end_date->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('curator.challenges.entries', $challenge) }}" 
                                   class="btn-primary text-center text-sm py-2">
                                    Entries
                                </a>
                                <a href="{{ route('curator.challenges.edit', $challenge) }}" 
                                   class="btn-secondary text-center text-sm py-2">
                                    Edit
                                </a>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('curator.challenges.destroy', $challenge) }}" method="POST" class="col-span-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-red-600 hover:bg-red-700 text-white rounded-xl text-center text-sm py-2 transition-all"
                                            onclick="return confirm('Are you sure you want to delete this challenge? All entries will be lost.')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($challenges->hasPages())
                <div class="mt-8">
                    {{ $challenges->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">
                    @if(request('status'))
                        No {{ ucfirst(request('status')) }} Challenges
                    @else
                        No Challenges Yet
                    @endif
                </h3>
                <p class="text-gray-400 mb-6">
                    @if(request('status'))
                        You don't have any {{ request('status') }} challenges at the moment.
                    @else
                        Create your first challenge to engage the community!
                    @endif
                </p>
                <a href="{{ route('curator.challenges.create') }}" class="btn-primary inline-flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Create Challenge</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection