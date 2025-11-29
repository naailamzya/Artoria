<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Artoria') }} - @yield('title', 'Show Your Art')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased custom-scrollbar">
    {{-- Background Effects --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-artoria-500/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl animate-pulse-slow animate-delay-200"></div>
    </div>

    {{-- NAVBAR - Fixed di atas --}}
    @include('components.navbar')

    {{-- Content Wrapper dengan padding top untuk offset navbar --}}
    <div class="min-h-screen pt-20">
        <main class="flex-1">
            {{-- Flash Messages --}}
            @if(session('success') || session('error') || session('warning') || session('info'))
                <div class="container mx-auto px-4 pt-6">
                    @if(session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif
                    @if(session('error'))
                        <x-alert type="error" :message="session('error')" />
                    @endif
                    @if(session('warning'))
                        <x-alert type="warning" :message="session('warning')" />
                    @endif
                    @if(session('info'))
                        <x-alert type="info" :message="session('info')" />
                    @endif
                </div>
            @endif

            {{-- Page Content (dari @yield('content')) --}}
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('components.footer')
    </div>

    {{-- Modals Container --}}
    <div id="modals-container"></div>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>