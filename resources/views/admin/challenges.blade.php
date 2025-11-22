<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Challenges') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    @if($challenges->count() > 0)
                        <div class="space-y-6">
                            @foreach($challenges as $challenge)
                                <div class="border rounded-lg p-6 hover:shadow-lg transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $challenge->title }}</h3>
                                            <p class="text-gray-700 mb-4">{{ $challenge->description }}</p>
                                            
                                            <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-4">
                                                <span>👤 Curator: {{ $challenge->curator->name }}</span>
                                                <span>📅 Deadline: {{ $challenge->deadline->format('d M Y') }}</span>
                                                @if($challenge->reward)
                                                    <span>💰 Reward: Rp {{ number_format($challenge->reward) }}</span>
                                                @endif
                                            </div>

                                            @if($challenge->rules)
                                                <div class="bg-gray-50 p-4 rounded mb-4">
                                                    <h4 class="font-semibold mb-2">Rules:</h4>
                                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $challenge->rules }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex gap-4 pt-4 border-t">
                                        <form action="{{ route('admin.challenges.review', $challenge->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded"
                                                onclick="return confirm('Approve this challenge?')">
                                                ✅ Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.challenges.review', $challenge->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded"
                                                onclick="return confirm('Reject and delete this challenge?')">
                                                ❌ Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $challenges->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No pending challenges to review.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>