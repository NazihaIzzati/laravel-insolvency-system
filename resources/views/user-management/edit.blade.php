@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
                    <p class="text-gray-600 mt-1">Update user information and permissions</p>
                </div>
                <a href="{{ route('user-management.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                   style="background-color: #dc2626;"
                   onmouseover="this.style.backgroundColor='#b91c1c';"
                   onmouseout="this.style.backgroundColor='#dc2626';"
                   title="Return to user management list">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Users
                </a>
            </div>
        </div>

        <!-- Edit User Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">User Information</h3>
                <p class="text-sm text-gray-500 mt-1">Update the details for {{ $user->name }}</p>
            </div>
            
            <form action="{{ route('user-management.update', $user) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2" title="Enter the user's complete full name">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('name') border-red-300 @enderror" 
                               placeholder="Enter full name"
                               title="Enter the user's complete full name"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Staff ID -->
                    <div>
                        <label for="login_id" class="block text-sm font-medium text-gray-700 mb-2" title="Unique staff identifier for the user">
                            Staff ID
                        </label>
                        <input type="text" 
                               id="login_id" 
                               name="login_id" 
                               value="{{ old('login_id', $user->login_id) }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('login_id') border-red-300 @enderror" 
                               placeholder="Enter staff ID"
                               title="Enter the unique staff identifier">
                        @error('login_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2" title="User's email address for notifications and password resets">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('email') border-red-300 @enderror" 
                               placeholder="Enter email address"
                               title="Enter the user's email address for notifications"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Required for password reset emails and notifications</p>
                    </div>


                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2" title="Select the user's access level and permissions">
                            User Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" 
                                name="role" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('role') border-red-300 @enderror"
                                title="Choose the appropriate role for this user"
                                required>
                            <option value="">Select a role</option>
                            <option value="superuser" {{ old('role', $user->role) == 'superuser' ? 'selected' : '' }}>Super User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="id_management" {{ old('role', $user->role) == 'id_management' ? 'selected' : '' }}>ID Management</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Branch Code -->
                    <div>
                        <label for="branch_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Branch Code
                        </label>
                        <input type="text" 
                               id="branch_code" 
                               name="branch_code" 
                               value="{{ old('branch_code', $user->branch_code) }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('branch_code') border-red-300 @enderror" 
                               placeholder="Enter branch code">
                        @error('branch_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select id="status" 
                                name="status" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('status') border-red-300 @enderror">
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="expired" {{ old('status', $user->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Expiry Date
                        </label>
                        <input type="date" 
                               id="expiry_date" 
                               name="expiry_date" 
                               value="{{ old('expiry_date', $user->expiry_date?->format('Y-m-d')) }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('expiry_date') border-red-300 @enderror">
                        @error('expiry_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Role Description -->
                <div class="mt-6 p-4 bg-white rounded-lg">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Role Descriptions:</h4>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><strong>Super User:</strong> Full system access with all privileges</p>
                        <p><strong>Administrator:</strong> System administration and user management</p>
                        <p><strong>ID Management:</strong> Manage identity and user records</p>
                        <p><strong>Staff:</strong> Basic system access for daily operations</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('user-management.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                       title="Cancel changes and return to user list">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200"
                            title="Save all changes to user information">
                        <i class="fas fa-save mr-2"></i>
                        Update User
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Management Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Password Management</h3>
                <p class="text-sm text-gray-500 mt-1">Manage user password and send reset emails</p>
            </div>
            
            <!-- Send Password Reset Email Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex-1">
                        <h4 class="text-md font-medium text-gray-900">Send Password Reset Email</h4>
                        <p class="text-sm text-gray-500 mt-1">
                            @if($user->email)
                                Generate a secure password reset link for {{ $user->email }}
                            @else
                                <span class="text-red-600 font-medium">User does not have an email address configured</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        @if($user->email)
                            <form action="{{ route('user-management.send-password-reset', $user) }}" method="POST" class="inline" id="password-reset-form-edit">
                                @csrf
                                <button type="button" 
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 shadow-sm"
                                        title="Send password reset email to user"
                                        onclick="confirmPasswordResetEdit('{{ $user->email }}')">
                                    <i class="fas fa-envelope mr-2"></i>
                                    Send Reset Email
                                </button>
                            </form>
                        @else
                            <button type="button" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed"
                                    disabled
                                    title="User does not have an email address">
                                <i class="fas fa-envelope mr-2"></i>
                                No Email Address
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Change Password Section -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-md font-medium text-gray-900">Manual Password Change</h4>
                <p class="text-sm text-gray-500 mt-1">Manually update the user's password</p>
            </div>
            
            <form action="{{ route('user-management.change-password', $user) }}" method="POST" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               minlength="12"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('password') border-red-300 @enderror" 
                               placeholder="Enter new password (minimum 12 characters)"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               minlength="12"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200" 
                               placeholder="Confirm new password (minimum 12 characters)"
                               required>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                            title="Update the user's password">
                        <i class="fas fa-key mr-2"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmPasswordResetEdit(email) {
    Swal.fire({
        title: 'Send Password Reset Email?',
        html: `Are you sure you want to send a password reset email to <strong>${email}</strong>?<br><br>This will send a secure link for the user to reset their password.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#7c3aed',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Send Email',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Sending Email...',
                text: 'Please wait while we send the password reset email.',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit the form (try both possible form IDs)
            const form = document.getElementById('password-reset-form-edit') || document.getElementById('password-reset-form-description');
            if (form) {
                form.submit();
            }
        }
    });
}
</script>
@endsection
