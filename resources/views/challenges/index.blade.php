<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Challenges') }}
            </h2>
            @auth
                @if(Auth::user()->status === 'curator')
                    <a href="{{ route('challenges.create') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        + Create Challenge
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($challenges->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($challenges as $challenge)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                        🏆 {{ ucfirst($challenge->status) }}
                                    </span>
                                    @if($challenge->reward)
                                        <span class="text-green-600 font-bold text-sm">💰 Rp {{ number_format($challenge->reward) }}</span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $challenge->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $challenge->description }}</p>

                                <div class="text-sm text-gray-500 mb-4">
                                    <p>📅 Deadline: {{ $challenge->deadline->format('d M Y') }}</p>
                                    <p>👤 By: {{ $challenge->curator->name }}</p>
                                    <p>📊 Submissions: {{ $challenge->submissions->count() }}</p>
                                </div>

                                <a href="{{ route('challenges.show', $challenge->id) }}" 
                                    class="block text-center bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-500">No active challenges at the moment.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>