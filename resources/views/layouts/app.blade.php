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

    {{-- Hapus Alpine.js dari CDN jika sudah ada di app.js --}}
    {{-- Jika di app.js sudah include Alpine, jangan load double --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script> --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    
    {{-- Global CSS Fix untuk klik --}}
    <style>
        button:not(:disabled),
        a:not([href="#"]):not([href="javascript:void(0)"]):not(:disabled),
        [role="button"]:not(:disabled),
        input[type="submit"]:not(:disabled),
        input[type="button"]:not(:disabled),
        .btn-primary,
        .btn-secondary {
            cursor: pointer !important;
            pointer-events: auto !important;
            position: relative;
        }
        
        .glass button,
        .glass a {
            z-index: 20 !important;
        }
        
        .pointer-events-none {
            pointer-events: none !important;
        }
        
        .min-h-screen.pt-20,
        main {
            position: relative;
            z-index: 10;
        }
        
        #modals-container {
            z-index: 9999;
        }
    </style>
</head>
<body class="font-sans antialiased custom-scrollbar">
    {{-- Background Effects --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-artoria-500/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl animate-pulse-slow animate-delay-200"></div>
    </div>

    @include('components.navbar')

    <div class="min-h-screen pt-20">
        <main class="flex-1">
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

            @yield('content')
        </main>

        @include('components.footer')
    </div>

    <div id="modals-container"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded and parsed');
            
            fixAllButtons();
            
            if (typeof Alpine !== 'undefined') {
                console.log('Alpine.js loaded:', Alpine.version);
                setupAlpineCompat();
            } else {
                console.warn('Alpine.js not found, using vanilla JS');
            }

            setupGlobalClickHandler();
        });
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPage);
        } else {
            initPage();
        }
        
        function initPage() {
            console.log('Page initialization');
            
            const submitButtons = document.querySelectorAll(
                'button[type="submit"], ' +
                'button:contains("Submit"), ' +
                '[class*="submit"], ' +
                '.btn-primary'
            );
            
            submitButtons.forEach(button => {
                if (!button.hasAttribute('data-fixed')) {
                    button.setAttribute('data-fixed', 'true');
                    button.style.cursor = 'pointer';
                    button.style.pointerEvents = 'auto';
                    button.style.position = 'relative';
                    button.style.zIndex = '100';

                    button.addEventListener('click', function(e) {
                        console.log('Button emergency click:', this.textContent.trim(), this.type);
                        
                        if (this.type === 'submit') {
                            const form = this.closest('form');
                            if (form && !e.defaultPrevented) {
                                console.log('Emergency form submission');
                                form.submit();
                            }
                        }
                    }, { capture: true });
                }
            });
            
            document.querySelectorAll('a[href]').forEach(link => {
                link.style.cursor = 'pointer';
                link.style.pointerEvents = 'auto';
            });
        }
        
        function fixAllButtons() {
            console.log('Fixing all buttons...');

            const interactiveElements = [
                'button',
                'a[href]',
                'input[type="submit"]',
                'input[type="button"]',
                '[role="button"]',
                '.btn',
                '.btn-primary',
                '.btn-secondary',
                '[onclick]'
            ].join(', ');
            
            const elements = document.querySelectorAll(interactiveElements);
            console.log('Found', elements.length, 'interactive elements');
            
            elements.forEach(el => {
                el.style.pointerEvents = 'auto';
                el.style.cursor = 'pointer';
                el.style.userSelect = 'auto';
                el.style.webkitUserSelect = 'auto';

                if (!el.classList.contains('no-hover')) {
                    el.addEventListener('mouseenter', () => {
                        el.style.transform = 'translateY(-1px)';
                    });
                    el.addEventListener('mouseleave', () => {
                        el.style.transform = 'translateY(0)';
                    });
                }
    
                if (el.disabled || el.getAttribute('aria-disabled') === 'true') {
                    console.log('Disabled element:', el);
                    el.style.cursor = 'not-allowed';
                    el.style.opacity = '0.6';
                }
            });
        }
        
        function setupAlpineCompat() {
            window.addEventListener('submit-modal', function() {
                console.log('Global submit-modal event received');
                
                const modal = document.querySelector('[x-data*="submit"], [x-show*="submit"], #submitModal');
                if (modal && typeof Alpine !== 'undefined') {
                    Alpine.nextTick(() => {
                        Alpine.store('modal', { show: true });
                        console.log('Modal should be shown via Alpine');
                    });
                }
            });
            
            document.querySelectorAll('[x-cloak]').forEach(el => {
                el.style.display = 'none';
            });
            
            Alpine.nextTick(() => {
                document.querySelectorAll('[x-cloak]').forEach(el => {
                    el.style.display = '';
                });
            });
        }
        
        function setupGlobalClickHandler() {
            document.addEventListener('click', function(e) {
                const target = e.target;
                const isInteractive = 
                    target.tagName === 'BUTTON' ||
                    target.tagName === 'A' ||
                    target.tagName === 'INPUT' ||
                    target.hasAttribute('onclick') ||
                    target.classList.contains('btn');
                
                if (isInteractive) {
                    console.log('Click on interactive element:', {
                        tag: target.tagName,
                        type: target.type,
                        text: target.textContent?.trim() || target.value,
                        href: target.href,
                        class: target.className
                    });
                }
            }, true); 

            document.addEventListener('click', function(e) {
                const tag = e.target.tagName;
                if (['BUTTON', 'A', 'INPUT'].includes(tag)) {
                    setTimeout(() => {
                        console.log('Post-click check for:', tag);
                        
                        if (tag === 'BUTTON' && e.target.type === 'submit') {
                            const form = e.target.closest('form');
                            if (form) {
                                const submitted = sessionStorage.getItem('form_submitted');
                                if (!submitted) {
                                    console.warn('Form might not have submitted, forcing...');
                                }
                            }
                        }
                    }, 100);
                }
            });
        }
        
        window.forceClick = function(selector) {
            const el = document.querySelector(selector);
            if (el) {
                console.log('Forcing click on:', selector);
                el.click();
            } else {
                console.error('Element not found:', selector);
            }
        };
        
        setInterval(() => {
            const newButtons = document.querySelectorAll('button:not([data-fixed]), .btn:not([data-fixed])');
            if (newButtons.length > 0) {
                console.log('Auto-fixing', newButtons.length, 'new buttons');
                newButtons.forEach(btn => {
                    btn.setAttribute('data-fixed', 'true');
                    btn.style.cursor = 'pointer';
                    btn.style.pointerEvents = 'auto';
                });
            }
        }, 2000);
    </script>

    @stack('scripts')
</body>
</html>