<nav class="fixed top-0 left-0 right-0 z-50 bg-dark-900/80 backdrop-blur-xl border-b border-white/10">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-artoria-500 to-pink-500 rounded-xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <span class="text-2xl font-display font-bold gradient-text">
                    {{ config('app.name', 'Artoria') }}
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>
                <a href="{{ route('artworks.index') }}" class="nav-link {{ request()->routeIs('artworks.*') ? 'active' : '' }}">
                    Gallery
                </a>
                <a href="{{ route('challenges.index') }}" class="nav-link {{ request()->routeIs('challenges.*') ? 'active' : '' }}">
                    Challenges
                </a>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Admin Panel
                        </a>
                    @elseif(auth()->user()->role === 'curator')
                        <a href="{{ route('curator.pending') }}" class="nav-link {{ request()->routeIs('curator.*') ? 'active' : '' }}">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Curator Panel
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                
                <!-- Search Button -->
                <button onclick="toggleSearch()" class="p-2 text-gray-400 hover:text-white transition-colors rounded-lg hover:bg-white/5" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                @auth
                    <!-- Role-Based Primary Action Button -->
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hidden md:flex btn-primary items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span>Admin</span>
                        </a>
                    @elseif(auth()->user()->role === 'curator')
                        <a href="{{ route('curator.pending') }}" class="hidden md:flex btn-primary items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <span>Review</span>
                        </a>
                    @else
                        <a href="{{ route('artworks.create') }}" class="hidden md:flex btn-primary items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Upload</span>
                        </a>
                    @endif

                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center space-x-2 group" aria-label="User menu">
                            <img src="{{ auth()->user()->profile_picture_url }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-9 h-9 rounded-full object-cover border-2 border-transparent group-hover:border-artoria-500 transition-all duration-300">
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="user-menu" class="absolute right-0 mt-3 w-56 bg-dark-800/95 backdrop-blur-xl rounded-xl shadow-2xl py-2 border border-white/10 opacity-0 invisible transition-all duration-200 z-50">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-white/10">
                                <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ auth()->user()->email }}</p>
                                @if(auth()->user()->role !== 'member')
                                    <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full {{ auth()->user()->role === 'admin' ? 'bg-purple-500/20 text-purple-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>

                                <a href="{{ route('profile.show', auth()->user()) }}" class="dropdown-item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Profile</span>
                                </a>

                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Admin Panel</span>
                                    </a>
                                @elseif(auth()->user()->role === 'curator')
                                    <a href="{{ route('curator.pending') }}" class="dropdown-item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                        <span>Curator Panel</span>
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                    <span>Settings</span>
                                </a>
                            </div>

                            <!-- Logout -->
                            <div class="border-t border-white/10 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-red-400 hover:text-red-300 hover:bg-red-500/10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Guest Actions -->
                    <a href="{{ route('login') }}" class="hidden md:block btn-secondary">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary">
                        Sign Up
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-gray-400 hover:text-white transition-colors rounded-lg hover:bg-white/5" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden bg-dark-900/95 backdrop-blur-xl border-t border-white/10 hidden">
        <div class="container mx-auto px-4 py-4 space-y-2">
            <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                Home
            </a>
            <a href="{{ route('artworks.index') }}" class="mobile-nav-link {{ request()->routeIs('artworks.*') ? 'active' : '' }}">
                Gallery
            </a>
            <a href="{{ route('challenges.index') }}" class="mobile-nav-link {{ request()->routeIs('challenges.*') ? 'active' : '' }}">
                Challenges
            </a>
            
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Admin Panel
                    </a>
                @elseif(auth()->user()->role === 'curator')
                    <a href="{{ route('curator.pending') }}" class="mobile-nav-link {{ request()->routeIs('curator.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Curator Panel
                    </a>
                @else
                    <a href="{{ route('profile.show', auth()->user()) }}" class="mobile-nav-link">
                        Profile
                    </a>
                @endif

                <div class="border-t border-white/10 pt-2 mt-2">
                    @if(auth()->user()->role !== 'admin')
                        <a href="{{ route('artworks.create') }}" class="mobile-nav-link">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Upload Artwork
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-nav-link text-red-400 hover:text-red-300 w-full text-left">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-white/10 pt-2 mt-2 space-y-2">
                    <a href="{{ route('login') }}" class="mobile-nav-link">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="mobile-nav-link text-artoria-400">
                        Sign Up
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div id="search-modal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 hidden flex items-center justify-center p-4">
    <div class="max-w-2xl w-full glass rounded-2xl p-8 animate-fade-in">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-display font-bold text-white">Search Artworks</h2>
            <button onclick="toggleSearch()" class="p-2 text-gray-400 hover:text-white transition-colors rounded-lg hover:bg-white/10" aria-label="Close search">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('artworks.index') }}" method="GET" class="space-y-4">
            <div class="relative">
                <input type="text" 
                       name="search" 
                       placeholder="Search by title, artist, or tags..." 
                       class="w-full bg-dark-800 border border-white/20 rounded-xl px-5 py-4 pr-12 text-white placeholder-gray-500 focus:border-artoria-500 focus:ring-2 focus:ring-artoria-500/50 focus:outline-none transition-all"
                       autofocus>
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 p-2 text-artoria-400 hover:text-artoria-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
            
            <p class="text-sm text-gray-400 text-center">
                Press <kbd class="px-2 py-1 bg-dark-700 rounded text-xs">Enter</kbd> to search or <kbd class="px-2 py-1 bg-dark-700 rounded text-xs">Esc</kbd> to close
            </p>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Navigation Links */
    .nav-link {
        @apply text-gray-300 hover:text-white transition-all duration-300 font-medium relative;
    }
    
    .nav-link.active {
        @apply text-white;
    }
    
    .nav-link.active::after {
        content: '';
        @apply absolute -bottom-1 left-0 right-0 h-0.5 bg-gradient-to-r from-artoria-500 to-pink-500;
    }

    /* Mobile Navigation Links */
    .mobile-nav-link {
        @apply block px-4 py-3 text-gray-300 hover:text-white hover:bg-white/5 rounded-lg transition-all duration-300;
    }

    .mobile-nav-link.active {
        @apply text-white bg-white/5;
    }

    /* Dropdown Items */
    .dropdown-item {
        @apply flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-all duration-200;
    }

    /* Glass Effect */
    .glass {
        background: rgba(17, 24, 39, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Gradient Text */
    .gradient-text {
        background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Animation */
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    /* Keyboard Shortcut Badge */
    kbd {
        @apply inline-flex items-center justify-center font-mono font-semibold;
    }
</style>
@endpush

@push('scripts')
<script>
let isUserMenuOpen = false;
let isMobileMenuOpen = false;
let isSearchOpen = false;

function toggleUserMenu() {
    const menu = document.getElementById('user-menu');
    isUserMenuOpen = !isUserMenuOpen;
    
    if (isUserMenuOpen) {
        menu.classList.remove('opacity-0', 'invisible');
        menu.classList.add('opacity-100', 'visible');
    } else {
        menu.classList.remove('opacity-100', 'visible');
        menu.classList.add('opacity-0', 'invisible');
    }
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    isMobileMenuOpen = !isMobileMenuOpen;
    menu.classList.toggle('hidden');
}

function toggleSearch() {
    const modal = document.getElementById('search-modal');
    isSearchOpen = !isSearchOpen;
    
    if (isSearchOpen) {
        modal.classList.remove('hidden');
        modal.querySelector('input[name="search"]').focus();
    } else {
        modal.classList.add('hidden');
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const userMenu = document.getElementById('user-menu');
    const userButton = event.target.closest('[onclick="toggleUserMenu()"]');
    
    if (isUserMenuOpen && !userMenu?.contains(event.target) && !userButton) {
        userMenu.classList.remove('opacity-100', 'visible');
        userMenu.classList.add('opacity-0', 'invisible');
        isUserMenuOpen = false;
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(event) {
    // Open search with Ctrl+K or Cmd+K
    if ((event.ctrlKey || event.metaKey) && event.key === 'k') {
        event.preventDefault();
        toggleSearch();
    }
    
    // Close search with Escape
    if (event.key === 'Escape' && isSearchOpen) {
        toggleSearch();
    }
});
</script>
@endpush