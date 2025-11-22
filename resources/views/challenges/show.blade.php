<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Challenge Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                            🏆 {{ ucfirst($challenge->status) }}
                        </span>
                        @if($challenge->reward)
                            <span class="text-green-600 font-bold text-lg">💰 Rp {{ number_format($challenge->reward) }}</span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $challenge->title }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-700">{{ $challenge->description }}</p>
                        </div>

                        @if($challenge->rules)
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Rules</h3>
                                <p class="text-gray-700 whitespace-pre-line">{{ $challenge->rules }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-6 text-sm text-gray-600 mb-6">
                        <p>📅 Deadline: <span class="font-semibold">{{ $challenge->deadline->format('d M Y, H:i') }}</span></p>
                        <p>👤 Curator: <a href="{{ route('profile.show', $challenge->curator->id) }}" class="text-blue-600 hover:underline">{{ $challenge->curator->name }}</a></p>
                        <p>📊 Submissions: <span class="font-semibold">{{ $challenge->submissions->count() }}</span></p>
                    </div>

                    <!-- Submit Button -->
                    @auth
                        @if($challenge->status === 'active' && $challenge->deadline > now())
                            @if($hasSubmitted)
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                    ✅ You have already submitted to this challenge!
                                </div>
                            @else
                                <button onclick="document.getElementById('submitModal').classList.remove('hidden')"
                                    class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded">
                                    Submit Your Artwork
                                </button>
                            @endif
                        @elseif($challenge->deadline < now())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                ⏰ This challenge has ended.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded inline-block">
                            Login to Submit
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Submissions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Submissions ({{ $challenge->submissions->count() }})</h2>

                    @if($challenge->submissions->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($challenge->submissions as $submission)
                                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <a href="{{ route('artworks.show', $submission->artwork->id) }}">
                                        <img src="{{ asset('storage/' . $submission->artwork->file_path) }}" 
                                            alt="{{ $submission->artwork->title }}" 
                                            class="w-full h-48 object-cover">
                                    </a>
                                    <div class="p-4">
                                        <a href="{{ route('artworks.show', $submission->artwork->id) }}" 
                                            class="font-semibold text-gray-900 hover:text-blue-600">
                                            {{ $submission->artwork->title }}
                                        </a>
                                        <p class="text-sm text-gray-600 mt-1">
                                            by <a href="{{ route('profile.show', $submission->artwork->user->id) }}" 
                                                class="text-blue-600 hover:underline">
                                                {{ $submission->artwork->user->name }}
                                            </a>
                                        </p>
                                        
                                        <!-- Winner Badge -->
                                        @if($submission->winner)
                                            <div class="mt-2">
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold">
                                                    🏆 Rank #{{ $submission->winner->rank }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No submissions yet. Be the first to submit!</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Submit Modal -->
    @auth
        <div id="submitModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Submit Your Artwork</h3>
                    
                    <form action="{{ route('challenges.submit', $challenge->id) }}" method="POST">
                        @csrf
                        
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Artwork</label>
                        <select name="artwork_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 mb-4">
                            <option value="">Choose an artwork...</option>
                            @foreach(Auth::user()->artworks as $artwork)
                                <option value="{{ $artwork->id }}">{{ $artwork->title }}</option>
                            @endforeach
                        </select>

                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Submit
                            </button>
                            <button type="button" onclick="document.getElementById('submitModal').classList.add('hidden')"
                                class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</x-app-layout>