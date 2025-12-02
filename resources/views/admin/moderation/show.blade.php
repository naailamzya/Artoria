@extends('layouts.app')

@section('title', 'Review Report #' . $report->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-display font-bold text-white mb-2">
                    Review <span class="gradient-text">Report #{{ $report->id }}</span>
                </h1>
                <p class="text-gray-400">Take action on reported content</p>
            </div>
            <a href="{{ route('admin.moderation.index') }}" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Moderation
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Report Details --}}
        <div class="lg:col-span-1">
            <div class="glass rounded-2xl p-6 sticky top-8 space-y-6">
                {{-- Status --}}
                <div class="text-center pb-6 border-b border-white/10">
                    @if($report->status === 'pending')
                        <div class="w-20 h-20 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                            <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <span class="px-4 py-2 bg-yellow-500/20 border border-yellow-500/40 text-yellow-300 text-sm font-semibold rounded-lg">
                            Pending Review
                        </span>
                    @elseif($report->status === 'reviewed')
                        <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="px-4 py-2 bg-green-500/20 border border-green-500/40 text-green-300 text-sm font-semibold rounded-lg">
                            Reviewed
                        </span>
                    @else
                        <div class="w-20 h-20 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <span class="px-4 py-2 bg-blue-500/20 border border-blue-500/40 text-blue-300 text-sm font-semibold rounded-lg">
                            Dismissed
                        </span>
                    @endif
                </div>

                {{-- Report Info --}}
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-400 text-xs mb-1">Report Type</p>
                        <span class="px-3 py-1 rounded-lg text-sm font-semibold {{ $report->reportable_type === 'App\Models\Artwork' ? 'bg-red-500/20 text-red-300' : 'bg-blue-500/20 text-blue-300' }}">
                            {{ $report->reportable_type === 'App\Models\Artwork' ? '🖼️ Artwork' : '💬 Comment' }}
                        </span>
                    </div>

                    <div>
                        <p class="text-gray-400 text-xs mb-1">Reported By</p>
                        <div class="flex items-center space-x-2">
                            @if($report->reporter->profile_picture)
                                <img src="{{ Storage::url($report->reporter->profile_picture) }}" 
                                     alt="{{ $report->reporter->name }}" 
                                     class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-artoria-500 to-pink-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($report->reporter->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-white font-semibold text-sm">{{ $report->reporter->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $report->reporter->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-gray-400 text-xs mb-1">Reported At</p>
                        <p class="text-white text-sm">{{ $report->created_at->format('M d, Y H:i') }}</p>
                        <p class="text-gray-500 text-xs">{{ $report->created_at->diffForHumans() }}</p>
                    </div>

                    @if($report->status !== 'pending' && $report->reviewer)
                        <div class="pt-4 border-t border-white/10">
                            <p class="text-gray-400 text-xs mb-1">Reviewed By</p>
                            <div class="flex items-center space-x-2">
                                @if($report->reviewer->profile_picture)
                                    <img src="{{ Storage::url($report->reviewer->profile_picture) }}" 
                                         alt="{{ $report->reviewer->name }}" 
                                         class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($report->reviewer->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-white font-semibold text-sm">{{ $report->reviewer->name }}</p>
                                    <p class="text-gray-500 text-xs">{{ $report->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Quick Actions (Only for Pending) --}}
                @if($report->status === 'pending' && $report->reportable)
                    <div class="pt-6 border-t border-white/10 space-y-3">
                        <p class="text-gray-400 text-xs font-semibold uppercase mb-3">Quick Actions</p>
                        
                        <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Dismiss this report? The content will remain published.')"
                                    class="w-full px-4 py-3 bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/40 text-blue-300 font-semibold rounded-xl transition-all flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Dismiss Report
                            </button>
                        </form>

                        <form action="{{ route('admin.reports.take-down', $report) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('DELETE the reported content? This action CANNOT be undone!')"
                                    class="w-full px-4 py-3 bg-red-500/20 hover:bg-red-500/30 border border-red-500/40 text-red-300 font-semibold rounded-xl transition-all flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Take Down Content
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Content Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Report Reason --}}
            <div class="glass rounded-2xl p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Report Reason
                </h3>
                <div class="bg-black/30 rounded-xl p-4 border border-red-500/20">
                    <p class="text-white text-lg">{{ $report->reason }}</p>
                </div>
            </div>

            {{-- Reported Content --}}
            @if($report->reportable)
                <div class="glass rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Reported Content
                    </h3>

                    @if($report->reportable_type === 'App\Models\Artwork')
                        {{-- Artwork Content --}}
                        <div class="space-y-4">
                            <div class="relative rounded-2xl overflow-hidden">
                                <img src="{{ Storage::url($report->reportable->image_path) }}" 
                                     alt="{{ $report->reportable->title }}" 
                                     class="w-full h-auto rounded-2xl">
                                <div class="absolute top-4 right-4">
                                    <a href="{{ route('artworks.show', $report->reportable) }}" 
                                       target="_blank"
                                       class="px-4 py-2 bg-black/70 backdrop-blur-sm text-white rounded-lg hover:bg-black/90 transition-all flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        View Original
                                    </a>
                                </div>
                            </div>

                            <div class="bg-black/30 rounded-xl p-4 border border-white/5">
                                <h4 class="text-lg font-bold text-white mb-2">{{ $report->reportable->title }}</h4>
                                @if($report->reportable->description)
                                    <p class="text-gray-400 text-sm mb-3">{{ $report->reportable->description }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between pt-3 border-t border-white/10">
                                    <div class="flex items-center space-x-2">
                                        @if($report->reportable->user->profile_picture)
                                            <img src="{{ Storage::url($report->reportable->user->profile_picture) }}" 
                                                 alt="{{ $report->reportable->user->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-artoria-500 to-pink-500 flex items-center justify-center text-white text-sm font-bold">
                                                {{ strtoupper(substr($report->reportable->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-white font-semibold text-sm">{{ $report->reportable->user->name }}</p>
                                            <p class="text-gray-500 text-xs">{{ $report->reportable->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-4 text-sm text-gray-400">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $report->reportable->likes_count ?? 0 }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $report->reportable->views_count ?? 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Comment Content --}}
                        <div class="space-y-4">
                            <div class="bg-black/30 rounded-xl p-6 border border-white/5">
                                <div class="flex items-start space-x-3 mb-4">
                                    @if($report->reportable->user->profile_picture)
                                        <img src="{{ Storage::url($report->reportable->user->profile_picture) }}" 
                                             alt="{{ $report->reportable->user->name }}" 
                                             class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-artoria-500 to-pink-500 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($report->reportable->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <p class="text-white font-semibold">{{ $report->reportable->user->name }}</p>
                                            <span class="text-gray-500 text-xs">{{ $report->reportable->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-300">{{ $report->reportable->content }}</p>
                                    </div>
                                </div>

                                @if($report->reportable->artwork)
                                    <div class="pt-4 border-t border-white/10">
                                        <p class="text-gray-500 text-xs mb-2">Comment on:</p>
                                        <a href="{{ route('artworks.show', $report->reportable->artwork) }}" 
                                           target="_blank"
                                           class="flex items-center space-x-3 p-3 bg-white/5 rounded-lg hover:bg-white/10 transition-all">
                                            <img src="{{ Storage::url($report->reportable->artwork->image_path) }}" 
                                                 alt="{{ $report->reportable->artwork->title }}" 
                                                 class="w-16 h-16 rounded-lg object-cover">
                                            <div>
                                                <p class="text-white font-semibold text-sm">{{ $report->reportable->artwork->title }}</p>
                                                <p class="text-gray-400 text-xs">by {{ $report->reportable->artwork->user->name }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @else
                {{-- Content Deleted --}}
                <div class="glass rounded-2xl p-12 text-center border-2 border-red-500/30">
                    <div class="w-20 h-20 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Content Has Been Deleted</h3>
                    <p class="text-gray-400">The reported content is no longer available.</p>
                </div>
            @endif

            {{-- Admin Action Log (if reviewed) --}}
            @if($report->status !== 'pending')
                <div class="glass rounded-2xl p-6 border-2 border-artoria-500/30">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Admin Action Log
                    </h3>
                    <div class="bg-black/30 rounded-xl p-4 border border-artoria-500/20">
                        <p class="text-artoria-400 font-semibold text-lg mb-2">
                            {{ $report->status === 'reviewed' ? 'Content Removed' : 'Report Dismissed' }}
                        </p>
                        @if($report->admin_action)
                            <p class="text-gray-300 text-sm">{{ $report->admin_action }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .glass {
        background: rgba(17, 24, 39, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>
@endpush
@endsection