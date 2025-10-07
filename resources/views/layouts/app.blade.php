<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Insolvency Data System') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">
    <div class="flex-1">
        <!-- Navigation -->
        @auth
            <nav class="bg-white border-b border-primary-200 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-primary-900 hover:text-primary-700 transition-colors duration-200">
                                Insolvency <span class="text-accent-500">Data System</span>
                            </a>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center">
                            <!-- User Profile Dropdown -->
                            <div class="relative group">
                                <button class="flex items-center space-x-2 px-2 py-2 rounded-lg hover:bg-primary-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-accent-500">
                                    <div class="w-8 h-8 bg-gradient-to-br from-accent-500 to-accent-600 rounded-full flex items-center justify-center shadow-sm">
                                        <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <i class="fas fa-chevron-down text-primary-400 group-hover:text-primary-600 transition-colors duration-200"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-primary-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="p-3">
                                        <div class="flex items-center space-x-3 mb-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-accent-500 to-accent-600 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-primary-900">{{ auth()->user()->name }}</p>
                                                <p class="text-xs text-primary-500">{{ auth()->user()->email }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="border-t border-primary-100 my-2"></div>
                                        
                                        <a href="{{ route('password.change') }}" class="flex items-center px-3 py-2 text-sm text-primary-700 hover:bg-primary-50 rounded-lg transition-colors duration-200 mb-2">
                                            <i class="fas fa-key mr-3 text-primary-400"></i>
                                            Change Password
                                        </a>
                                        
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-primary-700 hover:bg-primary-50 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-sign-out-alt mr-3 text-primary-400"></i>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </nav>
        @endauth

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Flash Messages will be handled by SweetAlert2 -->

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="text-sm text-gray-500">
                        © {{ date('Y') }} {{ config('app.name', 'Insolvency Data System') }}. All rights reserved.
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <div class="text-sm text-gray-500">
                        Version 1.0.0
                    </div>
                    <div class="text-sm text-gray-500">
                        Last updated: {{ date('M d, Y') }}
                    </div>
                </div>
            </div>
            
        </div>
    </footer>

    <!-- SweetAlert2 Flash Messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#22c55e',
                    confirmButtonText: 'OK',
                    timer: 5000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            @endif

            @if(session('info'))
                Swal.fire({
                    title: 'Information',
                    text: '{{ session('info') }}',
                    icon: 'info',
                    confirmButtonColor: '#3b82f6',
                    confirmButtonText: 'OK',
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif
        });
    </script>
</body>
</html>
