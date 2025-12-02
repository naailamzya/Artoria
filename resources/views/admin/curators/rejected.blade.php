@extends('layouts.app')

@section('title', 'Rejected Curator Applications')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Rejected <span class="gradient-text">Curator Applications</span>
            </h1>
            <p class="text-gray-400">List of curator applications that were rejected</p>
        </div>

        @if($rejectedCurators->count() > 0)
            <div class="glass rounded-2xl p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5 border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Brand</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Applied</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Artworks</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($rejectedCurators as $curator)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="{{ $curator->profile_picture_url }}" 
                                             alt="{{ $curator->name }}" 
                                             class="w-10 h-10 rounded-lg object-cover mr-3">
                                        <div>
                                            <div class="text-white font-semibold">{{ $curator->name }}</div>
                                            <div class="text-sm text-gray-400">{{ $curator->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                    {{ $curator->brand_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-400 text-sm">
                                    {{ $curator->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                    {{ $curator->artworks_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('admin.users.show', $curator) }}" 
                                       class="text-blue-400 hover:text-blue-300 transition-colors">
                                        View Profile
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($rejectedCurators->hasPages())
                    <div class="px-6 py-4 border-t border-white/10">
                        {{ $rejectedCurators->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="glass rounded-2xl p-12 text-center">
                <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Rejected Applications</h3>
                <p class="text-gray-400">No curator applications have been rejected yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection