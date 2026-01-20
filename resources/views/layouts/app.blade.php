<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Insolvency Information System') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Boxicons CDN -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body class="font-sans antialiased bg-white flex flex-col min-h-screen">
    <div class="flex-1">
        <!-- Navigation -->
        @auth
            <nav class="bg-white border-b border-gray-200 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ auth()->user()->isIdManagement() ? route('id-management.dashboard') : (auth()->user()->hasAdminPrivileges() ? route('admin.dashboard') : route('dashboard')) }}" class="flex items-center space-x-3 text-xl font-semibold text-gray-900 hover:text-gray-700 transition-colors duration-200">
                                <img src="{{ asset('images/logo_bmmb.png') }}" alt="BMMB Logo" class="h-10 w-auto">
                                <div class="w-px h-8 bg-gray-300"></div>
                                <span><span class="text-orange-500">Insolvency</span> <span class="text-gray-800">Data System</span></span>
                            </a>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center">
                            <!-- User Profile Dropdown -->
                            <div class="relative group">
                                <button class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <div class="w-8 h-8 rounded-full overflow-hidden shadow-sm">
                                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="hidden sm:block text-left">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-700">{{ auth()->user()->role_display }}</p>
                                    </div>
                                    <i class="bx bx-chevron-down text-gray-800 group-hover:text-gray-800 transition-colors duration-200"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="p-4">
                                        <!-- Profile Header -->
                                        <div class="flex items-center space-x-3 mb-4">
                                            <div class="w-12 h-12 rounded-full overflow-hidden shadow-md">
                                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-base font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                                <p class="text-sm text-gray-700">{{ auth()->user()->email }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Profile Information -->
                                        <div class="bg-white rounded-lg p-3 mb-4">
                                            <div class="grid grid-cols-2 gap-3 text-xs">
                                                <div class="flex items-center space-x-2">
                                                    <i class="bx bx-user text-gray-800"></i>
                                                    <div>
                                                        <p class="text-gray-700">Role</p>
                                                        <p class="font-medium text-gray-900">{{ auth()->user()->role_display }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <i class="bx bx-circle text-{{ auth()->user()->is_active ? 'green' : 'red' }}-400"></i>
                                                    <div>
                                                        <p class="text-gray-700">Status</p>
                                                        <p class="font-medium text-gray-900">{{ auth()->user()->is_active ? 'Active' : 'Inactive' }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <i class="bx bx-calendar text-gray-800"></i>
                                                    <div>
                                                        <p class="text-gray-700">Member Since</p>
                                                        <p class="font-medium text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <i class="bx bx-time text-gray-800"></i>
                                                    <div>
                                                        <p class="text-gray-700">Last Login</p>
                                                        <p class="font-medium text-gray-900">{{ auth()->user()->updated_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="border-t border-primary-100 my-3"></div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="space-y-1">
                                            <a href="{{ route('password.change') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">
                                                <i class="bx bx-key mr-3 text-gray-400"></i>
                                                Change Password
                                            </a>
                                            
                                            @if(auth()->user()->isAdmin())
                                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">
                                                    <i class="bx bx-cog mr-3 text-gray-400"></i>
                                                    Admin Panel
                                                </a>
                                            @endif
                                            
                                            @if(auth()->user()->isIdManagement())
                                                <a href="{{ route('id-management.dashboard') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">
                                                    <i class="bx bx-user-check mr-3 text-gray-400"></i>
                                                    ID Management
                                                </a>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('logout') }}" class="block">
                                                @csrf
                                                <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                                    <i class="bx bx-log-out mr-3 text-red-400"></i>
                                                    Logout
                                                </button>
                                            </form>
                                        </div>
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
                    <div class="text-sm text-gray-700">
                        © {{ date('Y') }} {{ config('app.name', 'Insolvency Information System') }}. All rights reserved.
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <div class="text-sm text-gray-700">
                        Version 1.0.0
                    </div>
                    <div class="text-sm text-gray-700">
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
