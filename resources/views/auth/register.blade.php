@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-neutral-100">
                <svg class="h-6 w-6 text-neutral-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-neutral-900">
                Create your account
            </h2>
            <p class="mt-2 text-center text-sm text-neutral-800">
                Or
                <a href="{{ route('login') }}" class="font-medium text-neutral-800 hover:text-neutral-700">
                    sign in to your existing account
                </a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required 
                           class="form-input @error('name') border-red-300 @enderror" 
                           placeholder="Enter your full name" 
                           value="{{ old('name') }}">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="form-input @error('email') border-red-300 @enderror" 
                           placeholder="Enter your email address" 
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" 
                            class="form-input @error('role') border-red-300 @enderror">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="form-label">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required minlength="12"
                           class="form-input @error('password') border-red-300 @enderror" 
                           placeholder="Enter your password (minimum 12 characters)">
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required minlength="12"
                           class="form-input @error('password_confirmation') border-red-300 @enderror" 
                           placeholder="Confirm your password (minimum 12 characters)">
                    @error('password_confirmation')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-neutral-500 hover:bg-neutral-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 transition-colors duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-neutral-700 group-hover:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Create Account
                </button>
            </div>
            
            <div class="text-sm text-neutral-800">
                By creating an account, you agree to our 
                <a href="#" class="text-neutral-800 hover:text-neutral-700">Terms of Service</a> 
                and 
                <a href="#" class="text-neutral-800 hover:text-neutral-700">Privacy Policy</a>.
            </div>
        </form>
    </div>
</div>
@endsection
