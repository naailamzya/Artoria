<nav class="sticky top-0 z-50 glass border-b border-white/10 backdrop-blur-2xl" 
     x-data="{ mobileMenuOpen: false, profileMenuOpen: false }">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            
            <div class="flex items-center space-x-8">

                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-artoria-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-display font-bold gradient-text hidden sm:block">Artoria</span>
                </a>

                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}" 
                       class="px-4 py-2 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 {{ request()->routeIs('home') ? 'bg-white/10 text-white' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('artworks.index') }}" 
                       class="px-4 py-2 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 {{ request()->routeIs('artworks.*') ? 'bg-white/10 text-white' : '' }}">
                        Explore
                    </a>
                    <a href="{{ route('challenges.index') }}" 
                       class="px-4 py-2 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300 {{ request()->routeIs('challenges.*') ? 'bg-white/10 text-white' : '' }}">
                        Challenges
                    </a>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                
                <form action="{{ route('artworks.search') }}" method="GET" class="hidden md:block">
                    <div class="relative">
                        <input type="text" 
                               name="q" 
                               placeholder="Search artworks..." 
                               class="w-64 pl-10 pr-4 py-2 glass rounded-xl text-sm text-white placeholder-gray-400 border-white/10 focus:border-artoria-500 focus:ring-2 focus:ring-artoria-500/50 transition-all duration-300">
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>

                @auth
                    @if(auth()->user()->isMember() || auth()->user()->isCurator())
                        <a href="{{ route('artworks.create') }}" 
                           class="hidden md:flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-artoria-500 to-artoria-600 text-white font-semibold rounded-xl hover:from-artoria-600 hover:to-artoria-700 transition-all duration-300 hover:scale-105 hover:shadow-neon-red">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Upload</span>
                        </a>
                    @endif

                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" 
                                class="flex items-center space-x-3 p-2 rounded-xl hover:bg-white/5 transition-all duration-300">
                            <img src="{{ auth()->user()->profile_picture_url }}" 
                                 alt="{{ auth()->user()->display_name }}" 
                                 class="w-10 h-10 rounded-xl object-cover border-2 border-white/10">
                            <div class="hidden lg:block text-left">
                                <p class="text-sm font-semibold text-white">{{ auth()->user()->display_name }}</p>
                                <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 glass border border-white/10 rounded-2xl shadow-2xl py-2"
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-white/10">
                                <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="py-2">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Admin Dashboard</span>
                                    </a>
                                @elseif(auth()->user()->isCurator() && auth()->user()->isActive())
                                    <a href="{{ route('curator.dashboard') }}" 
                                       class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Curator Dashboard</span>
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" 
                                       class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Dashboard</span>
                                    </a>
                                @endif

                                <a href="{{ route('profile.show', auth()->user()) }}" 
                                   class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-sm font-medium">My Profile</span>
                                </a>

                                @if(auth()->user()->isMember() || auth()->user()->isCurator())
                                    <a href="{{ route('artworks.mine') }}" 
                                       class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-sm font-medium">My Artworks</span>
                                    </a>

                                    <a href="{{ route('favorites.index') }}" 
                                       class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Favorites</span>
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-white/5 hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium">Settings</span>
                                </a>
                            </div>

                            <div class="border-t border-white/10 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center space-x-3 w-full px-4 py-2 text-artoria-400 hover:bg-artoria-500/10 hover:text-artoria-300 transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span class="text-sm font-medium">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-6 py-2 text-gray-300 font-semibold hover:text-white transition-all duration-300">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-2 bg-gradient-to-r from-artoria-500 to-artoria-600 text-white font-semibold rounded-xl hover:from-artoria-600 hover:to-artoria-700 transition-all duration-300 hover:scale-105 hover:shadow-neon-red">
                        Sign Up
                    </a>
                @endauth

                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="lg:hidden p-2 rounded-xl hover:bg-white/5 transition-all duration-300">
                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden pb-4"
         style="display: none;">
        
        <!-- Mobile Search -->
        <form action="{{ route('artworks.search') }}" method="GET" class="px-4 py-2">
            <input type="text" 
                   name="q" 
                   placeholder="Search artworks..." 
                   class="w-full px-4 py-2 glass rounded-xl text-sm text-white placeholder-gray-400 border-white/10 focus:border-artoria-500 focus:ring-2 focus:ring-artoria-500/50 transition-all duration-300">
        </form>

        <!-- Mobile Navigation Links -->
        <div class="space-y-1 px-4">
            <a href="{{ route('home') }}" 
               class="block px-4 py-2 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300">
                Home
            </a>
            <a href="{{ route('artworks.index') }}" 
               class="block px-4 py-2 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300">
                Explore
            </a>
            <a href="{{ route('challenges.index') }}" 
               class="block px-4 py-2 rounded-xl text-gray-300 hover:text-white hover:bg-white/5 transition-all duration-300">
                Challenges
            </a>

            @auth
                @if(auth()->user()->isMember() || auth()->user()->isCurator())
                    <a href="{{ route('artworks.create') }}" 
                       class="block px-4 py-2 bg-gradient-to-r from-artoria-500 to-artoria-600 text-white font-semibold rounded-xl text-center hover:from-artoria-600 hover:to-artoria-700 transition-all duration-300">
                        Upload Artwork
                    </a>
                @endif
            @endauth
        </div>
    </div>
</nav>