@extends('layouts.landing')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white-50 to-white-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[600px]">
                <!-- Left Column - Branding & Visual -->
                <div class="relative bg-gradient-to-br from-primary-500 to-primary-700 p-8 lg:p-12 flex flex-col justify-center">
                    <!-- Floating Background Elements -->
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full animate-pulse-slow"></div>
                        <div class="absolute top-1/4 -left-8 w-16 h-16 bg-white/5 rounded-full animate-float"></div>
                        <div class="absolute bottom-1/4 right-1/4 w-12 h-12 bg-white/15 rounded-full animate-pulse-slow" style="animation-delay: 1s;"></div>
                        <div class="absolute bottom-8 left-8 w-20 h-20 bg-white/8 rounded-full animate-float" style="animation-delay: 2s;"></div>
                    </div>
                    
                    <!-- Content -->
                    <div class="relative z-10">
                        <!-- Logo -->
                        <div class="flex items-center space-x-3 mb-8">
                            <img src="{{ asset('images/logo_bmmb_white.png') }}" alt="BMMB Logo" class="h-12 w-auto">
                            <div class="w-px h-12 bg-white/30"></div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Insolvency Information System</h1>
                                <p class="text-primary-100 text-sm">Secure Data Management</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Login Form -->
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <div class="w-full max-w-md mx-auto">
                        <!-- Form Header -->
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Sign In</h3>
                            <p class="text-gray-600">Enter your credentials to access your account</p>
                        </div>
                        
                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                            @csrf
                            
                            <!-- Staff ID Field -->
                            <div>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="staff_id" 
                                        name="staff_id" 
                                        value="{{ old('staff_id') }}"
                                        required 
                                        autofocus
                                        class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 @error('staff_id') border-red-500 @enderror"
                                        placeholder="Enter your staff ID"
                                    >
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class='bx bx-id-card text-gray-400'></i>
                                    </div>
                                </div>
                                @error('staff_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Password Field -->
                            <div>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password" 
                                        required
                                        class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror"
                                        placeholder="Enter your password"
                                    >
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class='bx bx-lock text-gray-400'></i>
                                    </div>
                                    <button 
                                        type="button" 
                                        onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                    >
                                        <i class='bx bx-hide' id="passwordToggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        id="remember" 
                                        name="remember" 
                                        class="h-4 w-4 text-gray-600 focus:ring-primary-500 border-gray-300 rounded"
                                        {{ old('remember') ? 'checked' : '' }}
                                    >
                                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                                        Remember me
                                    </label>
                                </div>
                                
                                @if (Route::has('password.request'))
                                    <a 
                                        href="{{ route('password.request') }}" 
                                        class="text-sm text-gray-600 hover:text-gray-500 transition-colors duration-200"
                                    >
                                        Forgot password?
                                    </a>
                                @endif
                            </div>
                            
                            <!-- Submit Button -->
                            <button 
                                type="submit" 
                                class="w-full bg-primary-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
                            >
                                <i class='bx bx-log-in mr-2'></i>
                                Sign In
                            </button>
                        </form>
                        
                        <!-- Additional Links -->
                        <div class="mt-8 text-center">
                            <p class="text-sm text-gray-600">
                                Need help? 
                                <a href="#" class="text-gray-600 hover:text-gray-500 font-medium transition-colors duration-200">
                                    Contact Support
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .animate-pulse-slow {
        animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    /* Form focus animations */
    .focus\:ring-primary-500:focus {
        --tw-ring-color: rgba(254, 128, 0, 0.5);
    }
    
    /* Button hover effects */
    .hover\:scale-\[1\.02\]:hover {
        transform: scale(1.02);
    }
    
    .active\:scale-\[0\.98\]:active {
        transform: scale(0.98);
    }
</style>

<!-- JavaScript -->
<script>
    // Password visibility toggle
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('passwordToggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bx-hide');
            toggleIcon.classList.add('bx-show');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bx-show');
            toggleIcon.classList.add('bx-hide');
        }
    }
    
    // Form validation and SweetAlert integration
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const staffId = document.getElementById('staff_id').value;
        const password = document.getElementById('password').value;
        
        if (!staffId || !password) {
            e.preventDefault();
            Swal.fire({
                title: 'Missing Information',
                text: 'Please fill in all required fields.',
                icon: 'warning',
                confirmButtonColor: '#FE8000',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Show loading state
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bx bx-loader-alt animate-spin mr-2"></i>Signing In...';
        submitBtn.disabled = true;
        
        // Re-enable button after 3 seconds (in case of slow response)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
    
    // Auto-focus staff ID field
    document.addEventListener('DOMContentLoaded', function() {
        const staffIdField = document.getElementById('staff_id');
        if (staffIdField && !staffIdField.value) {
            staffIdField.focus();
        }
    });
    
    // Enhanced input animations
    document.querySelectorAll('input[type="text"], input[type="password"]').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-primary-500');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-primary-500');
        });
    });
</script>
@endsection
