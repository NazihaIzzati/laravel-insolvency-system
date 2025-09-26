@extends('layouts.landing')

@section('title', 'Insolvency Data System - Secure Banking-Grade Data Management')

@section('content')
<!-- Hero Section - Banking Style -->
<section class="relative text-white overflow-hidden min-h-screen flex items-center" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 50%, #1e293b 75%, #0f172a 100%);">
    <!-- Abstract Design Pattern Background -->
    <div class="absolute inset-0 opacity-30">
        <!-- Large Geometric Shapes -->
        <div class="absolute top-20 left-10 w-96 h-96 rounded-full opacity-20" style="background: radial-gradient(circle, rgba(254, 80, 0, 0.3) 0%, transparent 70%);"></div>
        <div class="absolute top-40 right-20 w-80 h-80 rounded-full opacity-15" style="background: radial-gradient(circle, rgba(254, 80, 0, 0.2) 0%, transparent 70%);"></div>
        <div class="absolute bottom-20 left-1/4 w-64 h-64 rounded-full opacity-25" style="background: radial-gradient(circle, rgba(254, 80, 0, 0.25) 0%, transparent 70%);"></div>
        
        <!-- Abstract Lines and Shapes -->
        <div class="absolute top-0 right-0 w-full h-full">
            <svg class="w-full h-full opacity-10" viewBox="0 0 1200 800" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="lineGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#FE5000;stop-opacity:0.3" />
                        <stop offset="50%" style="stop-color:#FE5000;stop-opacity:0.1" />
                        <stop offset="100%" style="stop-color:#FE5000;stop-opacity:0" />
                    </linearGradient>
                </defs>
                <path d="M0,200 Q300,100 600,200 T1200,200" stroke="url(#lineGradient)" stroke-width="2" fill="none"/>
                <path d="M0,400 Q400,300 800,400 T1200,400" stroke="url(#lineGradient)" stroke-width="1.5" fill="none"/>
                <path d="M0,600 Q200,500 400,600 T800,600 T1200,600" stroke="url(#lineGradient)" stroke-width="1" fill="none"/>
                <circle cx="200" cy="150" r="3" fill="#FE5000" opacity="0.4"/>
                <circle cx="600" cy="350" r="2" fill="#FE5000" opacity="0.3"/>
                <circle cx="1000" cy="550" r="2.5" fill="#FE5000" opacity="0.35"/>
                <circle cx="400" cy="700" r="1.5" fill="#FE5000" opacity="0.25"/>
            </svg>
        </div>
        
        <!-- Floating Geometric Elements -->
        <div class="absolute top-32 right-1/3 w-4 h-4 rotate-45 opacity-20 floating-element" style="background-color: #FE5000;"></div>
        <div class="absolute top-64 right-1/2 w-6 h-6 rotate-12 opacity-15 pulsing-element" style="background-color: #FE5000;"></div>
        <div class="absolute bottom-32 left-1/3 w-3 h-3 rotate-45 opacity-25 drifting-element" style="background-color: #FE5000;"></div>
        <div class="absolute bottom-64 left-1/2 w-5 h-5 rotate-12 opacity-18 floating-element" style="background-color: #FE5000;"></div>
        
        <!-- Additional Animated Elements -->
        <div class="absolute top-1/4 left-1/6 w-2 h-2 rounded-full opacity-30 pulsing-element" style="background-color: #FE5000;"></div>
        <div class="absolute top-3/4 right-1/6 w-3 h-3 rounded-full opacity-25 drifting-element" style="background-color: #FE5000;"></div>
        <div class="absolute top-1/2 left-1/12 w-1 h-1 rounded-full opacity-40 floating-element" style="background-color: #FE5000;"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"><path d="M 60 0 L 0 0 0 60" fill="none" stroke="%23FE5000" stroke-width="0.5"/></pattern></defs><rect width="60" height="60" fill="url(%23grid)"/></svg>');"></div>
    </div>
    
    <!-- Additional Overlay for Depth -->
    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-slate-900/20 to-slate-800/30"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-center lg:text-left">
                <div class="mb-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white border border-orange-500" style="background-color: #FE5000;">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Bank-Grade Security Certified
                    </span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight mb-6 leading-tight">
                    Professional
                    <span class="block" style="color: #FE5000;">Insolvency Data</span>
                    <span class="block">Management Platform</span>
                </h1>
                
                <p class="text-xl text-slate-300 max-w-2xl mb-8 leading-relaxed">
                    Secure, enterprise-grade insolvency data management system designed for financial institutions, 
                    legal professionals, and corporate entities requiring the highest standards of data protection.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <a href="{{ route('login') }}" class="btn text-white px-8 py-4 text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300" style="background-color: #FE5000;" onmouseover="this.style.backgroundColor='#E04500'" onmouseout="this.style.backgroundColor='#FE5000'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Access Platform
                    </a>
                    <a href="#features" class="btn border-2 border-slate-300 text-slate-300 hover:bg-white hover:text-slate-900 px-8 py-4 text-lg font-semibold transition-all duration-300">
                        Learn More
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 text-sm text-slate-400">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" style="color: #FE5000;">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        SSL Encrypted
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" style="color: #FE5000;">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        ISO 27001 Certified
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" style="color: #FE5000;">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd"></path>
                        </svg>
                        24/7 Monitoring
                    </div>
                </div>
            </div>
            
            <!-- Right Content - Complete Muamalat Logo with Card -->
            <div class="relative">
                <!-- Banking Card Style Container -->
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 shadow-2xl">
                    <!-- Muamalat Logo -->
                    <div class="flex items-center justify-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/logo_bmmb_white.png') }}" alt="Bank Muamalat Logo" class="w-48 h-32 sm:w-56 sm:h-36 md:w-64 md:h-40 lg:w-72 lg:h-48 xl:w-80 xl:h-52 object-contain">
                        </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="mt-6 text-center">
                        <h3 class="text-xl font-semibold text-white mb-2">Bank Muamalat Malaysia Berhad</h3>
                        <p class="text-slate-300 text-sm">Islamic Banking Excellence</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
