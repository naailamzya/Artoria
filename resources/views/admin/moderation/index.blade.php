@extends('layouts.app')

@section('title', 'Moderation Queue')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Moderation Queue
            </h1>
            <p class="text-gray-400">Review reported content and take action</p>
        </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="stat-card border-2 border-yellow-500/30">
                <div class="text-3xl font-bold gradient-text mb-1">{{ $stats['pending_count'] }}</div>
                <div class="text-gray-400 text-sm">Pending Reports</div>
            </div>
            <div class="stat-card">
                <div class="text-3xl font-bold gradient-text mb-1">{{ $stats['reviewed_count'] }}</div>
                <div class="text-gray-400 text-sm">Reviewed</div>
            </div>
            <div class="stat-card">
                <div class="text-3xl font-bold gradient-text mb-1">{{ $stats['dismissed_count'] }}</div>
                <div class="text-gray-400 text-sm">Dismissed</div>
            </div>
        </div>

        <div class="flex justify-center mb-8">
            <div class="glass rounded-2xl p-2 inline-flex space-x-2">
                <a href="{{ route('admin.moderation.index', ['filter' => 'pending']) }}" 
                   class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'pending' ? 'bg-gradient-to-r from-artoria-500 to-artoria-600 text-white shadow-neon-red' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    Pending ({{ $stats['pending_count'] }})
                </a>
                <a href="{{ route('admin.moderation.index', ['filter' => 'reviewed']) }}" 
                   class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'reviewed' ? 'bg-gradient-to-r from-artoria-500 to-artoria-600 text-white shadow-neon-red' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    Reviewed
                </a>
                <a href="{{ route('admin.moderation.index', ['filter' => 'dismissed']) }}" 
                   class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'dismissed' ? 'bg-gradient-to-r from-artoria-500 to-artoria-600 text-white shadow-neon-red' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    Dismissed
                </a>
            </div>
        </div>

        @if($reports->count() > 0)
            <div class="space-y-6 mb-8">
                @foreach($reports as $report)
                    <div class="glass rounded-2xl p-6 border-2 {{ $report->isPending() ? 'border-yellow-500/30' : 'border-white/10' }}">
                        <div class="flex flex-col lg:flex-row gap-6">
                            <div class="flex-1 space-y-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="flex items-center space-x-3 mb-2">
                                            <span class="badge-{{ $report->reportable_type === 'App\Models\Artwork' ? 'red' : 'blue' }}">
                                                {{ $report->reportable_type === 'App\Models\Artwork' ? 'Artwork' : 'Comment' }}
                                            </span>
                                            @if($report->isPending())
                                                <span class="badge-yellow animate-pulse">Pending Review</span>
                                            @elseif($report->status === 'reviewed')
                                                <span class="badge-green">Reviewed</span>
                                            @else
                                                <span class="badge-blue">Dismissed</span>
                                            @endif
                                        </div>
                                        <h3 class="text-xl font-bold text-white mb-1">Report #{{ $report->id }}</h3>
                                        <p class="text-sm text-gray-400">
                                            Reported by {{ $report->reporter->display_name }} • {{ $report->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                <div class="glass rounded-xl p-4">
                                    <p class="text-xs text-gray-400 mb-1">Reason:</p>
                                    <p class="text-white">{{ $report->reason }}</p>
                                </div>

                                @if($report->reportable)
                                    <div class="glass rounded-xl p-4">
                                        <p class="text-xs text-gray-400 mb-2">Reported Content:</p>
                                        @if($report->reportable_type === 'App\Models\Artwork')
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ $report->reportable->image_url }}" 
                                                     alt="{{ $report->reportable->title }}" 
                                                     class="w-20 h-20 rounded-lg object-cover">
                                                <div>
                                                    <p class="text-white font-semibold">{{ $report->reportable->title }}</p>
                                                    <p class="text-sm text-gray-400">by {{ $report->reportable->user->display_name }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-white/5 rounded-lg p-3">
                                                <p class="text-gray-300 text-sm">{{ Str::limit($report->reportable->content, 150) }}</p>
                                                <p class="text-xs text-gray-500 mt-2">by {{ $report->reportable->user->display_name }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="glass rounded-xl p-4 border-2 border-red-500/30">
                                        <p class="text-red-400 text-sm">Content has been deleted</p>
                                    </div>
                                @endif

                                <!-- Admin Action (if reviewed) -->
                                @if(!$report->isPending())
                                    <div class="glass rounded-xl p-4 border-2 border-artoria-500/30">
                                        <p class="text-xs text-gray-400 mb-1">Admin Action:</p>
                                        <p class="text-artoria-400 font-semibold">{{ $report->admin_action }}</p>
                                        @if($report->reviewer)
                                            <p class="text-xs text-gray-500 mt-1">by {{ $report->reviewer->display_name }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            @if($report->isPending() && $report->reportable)
                                <div class="lg:w-64 space-y-3">
                                    <a href="{{ route('admin.reports.show', $report) }}" class="btn-primary w-full text-center">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Review Report
                                    </a>

                                    <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="note" value="No violation found">
                                        <button type="submit" 
                                                onclick="return confirm('Dismiss this report?')"
                                                class="w-full btn-secondary">
                                            Dismiss Report
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.reports.take-down', $report) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" 
                                                onclick="return confirm('DELETE the reported content? This cannot be undone!')"
                                                class="w-full px-6 py-3 bg-red-500/20 text-red-300 font-semibold rounded-xl hover:bg-red-500/30 transition-all duration-300">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Take Down Content
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $reports->appends(['filter' => $filter])->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">All Clear! 🎉</h3>
                <p class="text-gray-400 mb-6">
                    @if($filter === 'pending')
                        No pending reports to review
                    @elseif($filter === 'reviewed')
                        No reviewed reports yet
                    @else
                        No dismissed reports
                    @endif
                </p>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Back to Dashboard</a>
            </div>
        @endif
    </div>
</div>
@endsection