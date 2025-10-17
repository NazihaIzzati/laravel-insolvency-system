@extends('layouts.app')

@section('title', 'Create New User')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Create New User</h1>
                    <p class="text-gray-600 mt-1">Add a new user to the system</p>
                </div>
                <a href="{{ route('user-management.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors duration-200" 
                   style="background-color: #dc2626;"
                   onmouseover="this.style.backgroundColor='#b91c1c';"
                   onmouseout="this.style.backgroundColor='#dc2626';">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Users
                </a>
            </div>
        </div>

        <!-- Create User Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">User Information</h3>
                <p class="text-sm text-gray-500 mt-1">Fill in the details for the new user</p>
            </div>
            
            <form action="{{ route('user-management.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('name') border-red-300 @enderror" 
                               placeholder="Enter full name"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Staff ID -->
                    <div>
                        <label for="login_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Staff ID
                        </label>
                        <input type="text" 
                               id="login_id" 
                               name="login_id" 
                               value="{{ old('login_id') }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('login_id') border-red-300 @enderror" 
                               placeholder="Enter staff ID">
                        @error('login_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('password') border-red-300 @enderror" 
                               placeholder="Enter password"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200" 
                               placeholder="Confirm password"
                               required>
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            User Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" 
                                name="role" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('role') border-red-300 @enderror"
                                required>
                            <option value="">Select a role</option>
                            <option value="superuser" {{ old('role') == 'superuser' ? 'selected' : '' }}>Super User</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="id_management" {{ old('role') == 'id_management' ? 'selected' : '' }}>ID Management</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
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
                               value="{{ old('branch_code') }}"
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
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
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
                               value="{{ old('expiry_date') }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200 @error('expiry_date') border-red-300 @enderror">
                        @error('expiry_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Role Description -->
                <div class="mt-4 p-4 bg-white rounded-lg">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Role Descriptions:</h4>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><strong>Super User:</strong> Full system access with all privileges</p>
                        <p><strong>Administrator:</strong> System administration and user management</p>
                        <p><strong>ID Management:</strong> Manage identity and user records</p>
                        <p><strong>Staff:</strong> Basic system access for daily operations</p>
                    </div>
                </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('user-management.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
