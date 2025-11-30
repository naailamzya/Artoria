@extends('layouts.app')

@section('title', 'Pending Curator Applications')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-display font-bold text-white mb-2">
                    Pending Curator <span class="gradient-text">Applications</span>
                </h1>
                <p class="text-gray-400">Review and approve curator applications</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-1">Total Pending</p>
                    <p class="text-3xl font-bold text-white">{{ $pendingCurators->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-1">Total Approved</p>
                    <p class="text-3xl font-bold text-green-400">{{ $approvedCount ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm mb-1">Total Rejected</p>
                    <p class="text-3xl font-bold text-red-400">{{ $rejectedCount ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Pending Applications List --}}
    @if($pendingCurators->isEmpty())
        <div class="glass rounded-2xl p-12 text-center">
            <div class="w-20 h-20 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">No Pending Applications</h3>
            <p class="text-gray-400">All curator applications have been reviewed.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($pendingCurators as $curator)
                <div class="glass rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            {{-- User Info --}}
                            <div class="flex items-center space-x-4">
                                @if($curator->profile_picture)
                                    <img src="{{ Storage::url($curator->profile_picture) }}" 
                                         alt="{{ $curator->name }}" 
                                         class="w-16 h-16 rounded-full object-cover ring-2 ring-artoria-500">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-artoria-500 to-pink-500 flex items-center justify-center text-white font-bold text-xl ring-2 ring-artoria-500">
                                        {{ strtoupper(substr($curator->name, 0, 1)) }}
                                    </div>
                                @endif
                                
                                <div>
                                    <h3 class="text-xl font-bold text-white">{{ $curator->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $curator->email }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="px-3 py-1 bg-yellow-500/20 border border-yellow-500/40 text-yellow-300 text-xs font-semibold rounded-lg">
                                            Pending Review
                                        </span>
                                        <span class="text-gray-500 text-xs">
                                            Applied {{ $curator->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.users.show', $curator) }}" 
                                   class="btn-secondary text-sm py-2 px-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View Profile
                                </a>
                            </div>
                        </div>

                        {{-- Brand Info --}}
                        @if($curator->brand_name || $curator->brand_description)
                            <div class="bg-black/30 rounded-xl p-4 mb-4 border border-white/5">
                                <h4 class="text-sm font-semibold text-gray-300 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Brand Information
                                </h4>
                                @if($curator->brand_name)
                                    <p class="text-white font-semibold mb-1">{{ $curator->brand_name }}</p>
                                @endif
                                @if($curator->brand_description)
                                    <p class="text-gray-400 text-sm">{{ Str::limit($curator->brand_description, 200) }}</p>
                                @endif
                            </div>
                        @endif

                        {{-- Stats --}}
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="bg-black/30 rounded-xl p-3 border border-white/5 text-center">
                                <p class="text-gray-400 text-xs mb-1">Artworks</p>
                                <p class="text-white font-bold text-lg">{{ $curator->artworks_count ?? 0 }}</p>
                            </div>
                            <div class="bg-black/30 rounded-xl p-3 border border-white/5 text-center">
                                <p class="text-gray-400 text-xs mb-1">Followers</p>
                                <p class="text-white font-bold text-lg">{{ $curator->followers_count ?? 0 }}</p>
                            </div>
                            <div class="bg-black/30 rounded-xl p-3 border border-white/5 text-center">
                                <p class="text-gray-400 text-xs mb-1">Following</p>
                                <p class="text-white font-bold text-lg">{{ $curator->following_count ?? 0 }}</p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center space-x-3 pt-4 border-t border-white/10">
                            <form action="{{ route('admin.curators.approve', $curator) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to approve this curator application?')"
                                        class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-green-500/25 hover:shadow-green-500/40 hover:scale-105 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Approve Curator
                                </button>
                            </form>

                            <form action="{{ route('admin.curators.reject', $curator) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to reject this curator application?')"
                                        class="w-full px-6 py-3 bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:scale-105 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Reject Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
<style>
    .glass {
        background: rgba(17, 24, 39, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .glass:hover {
        background: rgba(17, 24, 39, 0.7);
        border-color: rgba(139, 92, 246, 0.3);
    }
</style>
@endpush
@endsection