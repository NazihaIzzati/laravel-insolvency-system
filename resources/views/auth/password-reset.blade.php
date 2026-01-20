@extends('layouts.landing')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-orange-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23f3f4f6" fill-opacity="0.3"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
    
    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-orange-200 rounded-full opacity-20 animate-pulse"></div>
    <div class="absolute top-40 right-20 w-16 h-16 bg-blue-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-20 left-20 w-12 h-12 bg-green-200 rounded-full opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Header Section -->
        <div class="text-center">
            @if(isset($success) && $success)
                <!-- Success State -->
                <div class="mx-auto h-20 w-20 flex items-center justify-center rounded-full bg-gradient-to-r from-green-400 to-green-600 shadow-lg animate-bounce">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-center text-4xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">
                    Password Reset Successful!
                </h2>
                <p class="mt-3 text-center text-lg text-gray-600 font-medium">
                    Your password has been updated successfully
                </p>
                <div class="mt-4 flex items-center justify-center">
                    <div class="flex items-center space-x-2 text-green-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm font-medium">Confirmation email sent</span>
                    </div>
                </div>
            @else
                <!-- Form State -->
                <div class="mx-auto h-20 w-20 flex items-center justify-center rounded-full bg-gradient-to-r from-orange-400 to-orange-600 shadow-lg">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-center text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">
                    Reset Your Password
                </h2>
                <p class="mt-3 text-center text-lg text-gray-600 font-medium">
                    Enter your new password below
                </p>
                <div class="mt-4 flex items-center justify-center">
                    <div class="flex items-center space-x-2 text-orange-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span class="text-sm font-medium">Secure password reset</span>
                    </div>
                </div>
            @endif
        </div>
        
        @if(isset($success) && $success)
            <!-- Success Message Card -->
            <div class="mt-8">
                <div class="bg-white rounded-2xl shadow-xl border border-green-100 p-8 text-center transform transition-all duration-300 hover:shadow-2xl">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Password Reset Complete!</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $message }}</p>
                    
                    <!-- Action Button -->
                    <div class="space-y-4">
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white text-lg font-semibold rounded-xl hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-4 focus:ring-green-200 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Go to Login
                        </a>
                        
                        <!-- Additional Info -->
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Your account is now secure with the new password
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Password Reset Form Card -->
            <div class="mt-8">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 transform transition-all duration-300 hover:shadow-2xl">
                    <form class="space-y-6" method="POST" action="{{ route('password.reset.submit') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">
                        
                        <!-- Password Fields -->
                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    New Password
                                </label>
                                <div class="relative">
                                    <input id="password" 
                                           name="password" 
                                           type="password" 
                                           required 
                                           minlength="12"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                           placeholder="Enter your new password">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Confirm Password
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation" 
                                           name="password_confirmation" 
                                           type="password" 
                                           required 
                                           minlength="12"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('password_confirmation') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                           placeholder="Confirm your new password">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" 
                                    class="w-full flex justify-center items-center px-6 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-lg font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-200 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                Reset Password
                            </button>
                        </div>

                        <!-- Back to Login Link -->
                        <div class="text-center">
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Login
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Security Notice -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-blue-800">Security Notice</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>This password reset link will expire in 1 hour for security reasons</li>
                                    <li>If you did not request this reset, please contact your administrator immediately</li>
                                    <li>Your new password should be strong and unique</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Custom Styles -->
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    @keyframes pulse-slow {
        0%, 100% { opacity: 0.2; }
        50% { opacity: 0.4; }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    .animate-pulse-slow {
        animation: pulse-slow 2s ease-in-out infinite;
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #f97316, #ea580c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .input-focus {
        transition: all 0.2s ease;
    }
    
    .input-focus:focus {
        transform: scale(1.02);
    }
    
    .button-hover {
        transition: all 0.3s ease;
    }
    
    .button-hover:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>

<script>
// Enhanced form interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add floating animation to background elements
    const floatingElements = document.querySelectorAll('.animate-pulse');
    floatingElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.5}s`;
    });
    
    // Add hover effects to cards
    const cards = document.querySelectorAll('.bg-white.rounded-2xl');
    cards.forEach(card => {
        card.classList.add('card-hover');
    });
    
    // Add focus effects to inputs
    const inputs = document.querySelectorAll('input[type="password"]');
    inputs.forEach(input => {
        input.classList.add('input-focus');
    });
    
    // Add hover effects to buttons
    const buttons = document.querySelectorAll('button, a[href]');
    buttons.forEach(button => {
        if (button.classList.contains('bg-gradient-to-r')) {
            button.classList.add('button-hover');
        }
    });
    
    // Password strength indicator (optional enhancement)
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = getPasswordStrength(password);
            updatePasswordStrengthIndicator(strength);
        });
    }
});

// Password strength calculation
function getPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return strength;
}

// Update password strength indicator
function updatePasswordStrengthIndicator(strength) {
    // This could be enhanced with a visual strength indicator
    console.log('Password strength:', strength);
}

// Show success/error messages with SweetAlert (layout handles these, but adding backup)
@if(session('success'))
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: '#FE8000',
        confirmButtonText: 'OK',
        timer: 5000,
        timerProgressBar: true
    });
});
@endif

@if(session('error'))
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'OK'
    });
});
@endif

// Show validation errors with SweetAlert
@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Validation Error',
        html: '<ul class="text-left">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        icon: 'error',
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'OK'
    });
});
@endif
</script>
@endsection
