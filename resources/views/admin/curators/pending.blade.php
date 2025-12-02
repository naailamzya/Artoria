@extends('layouts.app')

@section('title', 'Pending Curator Applications')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
 
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Pending <span class="gradient-text">Curator Applications</span>
            </h1>
            <p class="text-gray-400">Review and manage curator applications</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass rounded-2xl p-6 text-center">
                <div class="text-4xl font-bold gradient-text mb-2">{{ $pendingCurators->count() }}</div>
                <div class="text-gray-400">Pending Applications</div>
            </div>
            <div class="glass rounded-2xl p-6 text-center">
                <div class="text-4xl font-bold gradient-text mb-2">{{ $approvedCount }}</div>
                <div class="text-gray-400">Approved Curators</div>
            </div>
            <div class="glass rounded-2xl p-6 text-center">
                <div class="text-4xl font-bold gradient-text mb-2">{{ $rejectedCount }}</div>
                <div class="text-gray-400">Rejected Applications</div>
            </div>
        </div>

        @if($pendingCurators->count() > 0)
            <div class="glass rounded-2xl p-6 mb-8">
                <h2 class="text-2xl font-bold text-white mb-6">Review Applications</h2>
                
                @foreach($pendingCurators as $curator)
                <div class="glass rounded-xl p-6 mb-6 border-2 border-yellow-500/20">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4">
                            <img src="{{ $curator->profile_picture_url }}" 
                                 alt="{{ $curator->name }}" 
                                 class="w-16 h-16 rounded-xl object-cover">
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $curator->name }}</h3>
                                <p class="text-gray-400">{{ $curator->email }}</p>
                                
                                @if($curator->brand_name)
                                <div class="mt-2">
                                    <span class="text-sm text-gray-400">Brand:</span>
                                    <span class="ml-2 text-white font-semibold">{{ $curator->brand_name }}</span>
                                </div>
                                @endif
                                
                                @if($curator->portfolio_url)
                                <div class="mt-1">
                                    <span class="text-sm text-gray-400">Portfolio:</span>
                                    <a href="{{ $curator->portfolio_url }}" 
                                       target="_blank" 
                                       class="ml-2 text-artoria-400 hover:text-artoria-300">
                                        {{ Str::limit($curator->portfolio_url, 30) }}
                                    </a>
                                </div>
                                @endif
                                
                                <div class="mt-3 flex items-center space-x-4 text-sm">
                                    <span class="text-gray-400">Artworks: {{ $curator->artworks_count }}</span>
                                    <span class="text-gray-400">Applied: {{ $curator->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col space-y-2">
                            <form action="{{ route('admin.curators.approve', $curator) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg w-full transition-all duration-300 hover:scale-105">
                                    Approve Curator
                                </button>
                            </form>

                            <form action="{{ route('admin.curators.reject', $curator) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirmReject('{{ $curator->name }}')"
                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg w-full transition-all duration-300 hover:scale-105">
                                    Reject & Delete Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else

            <div class="glass rounded-2xl p-12 text-center">
                <div class="w-24 h-24 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Pending Applications</h3>
                <p class="text-gray-400 mb-6">There are no curator applications to review at this time.</p>
                <a href="{{ route('admin.users.index') }}" class="btn-primary inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    View All Users
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function confirmReject(userName) {
    return confirm(`DELETE USER ACCOUNT?\n\nUser "${userName}" will be:\n1. Rejected as curator\n2. Account permanently deleted\n3. Must register again\n\nThis action cannot be undone!`);
}
</script>

<style>
.glass {
    background: rgba(17, 24, 39, 0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.gradient-text {
    @apply bg-gradient-to-r from-artoria-400 to-pink-400 bg-clip-text text-transparent;
}

.btn-primary {
    @apply px-6 py-3 bg-gradient-to-r from-artoria-500 to-pink-500 text-white font-semibold rounded-xl 
           hover:opacity-90 transition-all duration-300 hover:scale-105;
}
</style>
@endsection