<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to Artoria</h1>
                    <p class="text-gray-600 mb-6">Discover and share amazing artworks from talented creators</p>
                    
                    @guest
                        <div class="space-x-4">
                            <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Get Started
                            </a>
                            <a href="{{ route('login') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Login
                            </a>
                        </div>
                    @endguest
                </div>
            </div>

            <!-- Active Challenge Banner -->
            @if(isset($activeChallenge))
                <div class="bg-purple-100 border border-purple-400 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-purple-900 mb-2">🏆 Active Challenge</h3>
                    <p class="text-purple-800 font-semibold">{{ $activeChallenge->title }}</p>
                    <p class="text-purple-700 text-sm mb-2">Deadline: {{ $activeChallenge->deadline->format('d M Y') }}</p>
                    <a href="{{ route('challenges.show', $activeChallenge->id) }}" class="text-purple-600 hover:text-purple-800 font-semibold">
                        View Details →
                    </a>
                </div>
            @endif

            <!-- Search Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('search') }}" method="GET" class="flex gap-4">
                        <input type="text" name="q" placeholder="Search artworks or creators..." 
                            value="{{ request('q') }}"
                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Categories</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('home') }}" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-full text-sm font-medium">
                            All
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('category.filter', $category->id) }}" 
                                class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Artworks Grid -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(isset($selectedCategory))
                        <h2 class="text-2xl font-bold mb-6">{{ $selectedCategory->name }}</h2>
                    @elseif(isset($keyword))
                        <h2 class="text-2xl font-bold mb-6">Search Results for "{{ $keyword }}"</h2>
                    @else
                        <h2 class="text-2xl font-bold mb-6">Latest Artworks</h2>
                    @endif

                    @if($artworks->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($artworks as $artwork)
                                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <a href="{{ route('artworks.show', $artwork->id) }}">
                                        <img src="{{ asset('storage/' . $artwork->file_path) }}" 
                                            alt="{{ $artwork->title }}" 
                                            class="w-full h-48 object-cover">
                                    </a>
                                    <div class="p-4">
                                        <a href="{{ route('artworks.show', $artwork->id) }}" 
                                            class="font-semibold text-gray-900 hover:text-blue-600">
                                            {{ $artwork->title }}
                                        </a>
                                        <p class="text-sm text-gray-600 mt-1">
                                            by <a href="{{ route('profile.show', $artwork->user->id) }}" 
                                                class="text-blue-600 hover:underline">
                                                {{ $artwork->user->name }}
                                            </a>
                                        </p>
                                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                            <span>❤️ {{ $artwork->likes->count() }}</span>
                                            <span>💬 {{ $artwork->comments->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No artworks found.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>