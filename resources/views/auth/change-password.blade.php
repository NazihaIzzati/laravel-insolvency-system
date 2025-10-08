@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="max-w-md mx-auto">
    <div class="professional-card">
        <div class="professional-section-header">
            <h2 class="text-lg font-semibold text-primary-900">Change Password</h2>
            <p class="text-sm text-primary-600 mt-1">Update your account password</p>
        </div>
        
        <div class="professional-section-content">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-primary-700 mb-2">
                        Current Password
                    </label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password" 
                        class="professional-input @error('current_password') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                        placeholder="Enter your current password"
                        required 
                        autocomplete="current-password"
                    >
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-primary-700 mb-2">
                        New Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="professional-input @error('password') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                        placeholder="Enter your new password"
                        required 
                        autocomplete="new-password"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-primary-700 mb-2">
                        Confirm New Password
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="professional-input"
                        placeholder="Confirm your new password"
                        required 
                        autocomplete="new-password"
                    >
                </div>

                <!-- Password Requirements -->
                <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-primary-900 mb-2">Password Requirements:</h4>
                    <ul class="text-xs text-primary-600 space-y-1">
                        <li class="flex items-center">
                            <i class="fas fa-check mr-2 text-primary-400"></i>
                            At least 8 characters long
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check mr-2 text-primary-400"></i>
                            Contains uppercase and lowercase letters
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check mr-2 text-primary-400"></i>
                            Contains at least one number
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check mr-2 text-primary-400"></i>
                            Contains at least one special character
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('dashboard') }}" class="professional-button">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Cancel
                    </a>
                    
                    <button type="submit" class="professional-button-primary">
                        <i class="fas fa-check mr-2"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
