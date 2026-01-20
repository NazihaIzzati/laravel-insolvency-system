@extends('layouts.landing')

@section('title', 'Insolvency Information System - Secure Data Management')

@section('content')
<!-- Hero Section -->
<section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 animated-gradient hero-pattern"></div>
    
    <!-- Floating Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <!-- Floating Particles -->
    <div class="particles">
        <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 4s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 6s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 8s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 10s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 12s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 14s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 16s;"></div>
        <div class="particle" style="left: 15%; animation-delay: 1s;"></div>
        <div class="particle" style="left: 25%; animation-delay: 3s;"></div>
        <div class="particle" style="left: 35%; animation-delay: 5s;"></div>
        <div class="particle" style="left: 45%; animation-delay: 7s;"></div>
        <div class="particle" style="left: 55%; animation-delay: 9s;"></div>
        <div class="particle" style="left: 65%; animation-delay: 11s;"></div>
        <div class="particle" style="left: 75%; animation-delay: 13s;"></div>
        <div class="particle" style="left: 85%; animation-delay: 15s;"></div>
        <div class="particle" style="left: 95%; animation-delay: 17s;"></div>
    </div>
    
    <!-- Content -->
    <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center animate-on-scroll">
            <!-- Logo and Title -->
            <div class="flex items-center justify-center space-x-4 mb-8">
                <img src="{{ asset('images/logo_bmmb_white.png') }}" alt="BMMB Logo" class="h-16 w-auto">
                <div class="w-px h-12 bg-white/30"></div>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight">
                    Secure <span class="text-yellow-300">Insolvency</span><br>
                    Data Management
                </h1>
            </div>
            <p class="text-2xl text-white/90 mb-12 max-w-4xl mx-auto">
                Professional system for managing bankruptcy and annulment records with enterprise-grade security, 
                real-time analytics, and comprehensive audit trails.
            </p>
            
            <!-- Single CTA Button -->
            <div class="mb-16">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-block bg-white text-gray-600 px-12 py-6 rounded-xl font-bold text-xl hover:bg-white transition-all duration-200 shadow-2xl hover:shadow-3xl transform hover:-translate-y-2">
                        <i class='bx bx-dashboard mr-3'></i>
                        Access Platform
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block bg-white text-gray-600 px-12 py-6 rounded-xl font-bold text-xl hover:bg-white transition-all duration-200 shadow-2xl hover:shadow-3xl transform hover:-translate-y-2">
                        <i class='bx bx-log-in mr-3'></i>
                        Access Platform
                    </a>
                @endauth
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-4xl mx-auto">
                <div class="animate-on-scroll">
                    <div class="text-4xl font-bold text-white mb-3">1000+</div>
                    <div class="text-xl text-white/80">Records Managed</div>
                </div>
                <div class="animate-on-scroll">
                    <div class="text-4xl font-bold text-white mb-3">99.9%</div>
                    <div class="text-xl text-white/80">Uptime</div>
                </div>
                <div class="animate-on-scroll">
                    <div class="text-4xl font-bold text-white mb-3">24/7</div>
                    <div class="text-xl text-white/80">Support</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class='bx bx-chevron-down text-white text-3xl'></i>
    </div>
</section>


@endsection