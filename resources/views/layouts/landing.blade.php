<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Insolvency Data System') }} - @yield('title', 'Professional Data Management Solutions')</title>
    <meta name="description" content="Professional insolvency data management solutions designed for modern businesses and legal professionals. Secure, efficient, and user-friendly platform.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <!-- Navigation - Clean White Style -->
    <nav class="bg-white shadow-sm border-b border-neutral-200 fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('landing') }}" class="text-2xl font-bold text-neutral-800">
                        {{ config('app.name') }}
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-neutral-800 hover:text-neutral-800 transition-colors duration-200 font-medium">
                        Security Features
                    </a>
                    <a href="#about" class="text-neutral-800 hover:text-neutral-800 transition-colors duration-200 font-medium">
                        Enterprise Solutions
                    </a>
                    <a href="#contact" class="text-neutral-800 hover:text-neutral-800 transition-colors duration-200 font-medium">
                        Support
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-neutral-800 hover:text-neutral-800 transition-colors duration-200 font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary px-6 py-2">
                        Enterprise Trial
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-neutral-800 hover:text-neutral-700 hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-500 focus:ring-inset" onclick="toggleMobileMenu()">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-neutral-200">
                <a href="#features" class="block px-3 py-2 text-base font-medium text-neutral-800 hover:text-neutral-800 hover:bg-neutral-50">
                    Security Features
                </a>
                <a href="#about" class="block px-3 py-2 text-base font-medium text-neutral-800 hover:text-neutral-800 hover:bg-neutral-50">
                    Enterprise Solutions
                </a>
                <a href="#contact" class="block px-3 py-2 text-base font-medium text-neutral-800 hover:text-neutral-800 hover:bg-neutral-50">
                    Support
                </a>
                <div class="border-t border-neutral-200 pt-4">
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-neutral-800 hover:text-neutral-800">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-neutral-800 hover:text-neutral-700">
                        Enterprise Trial
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
