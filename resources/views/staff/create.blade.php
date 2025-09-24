@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Add New Staff Member</h2>
                        <p class="text-gray-600 mt-1">Create a new staff profile</p>
                    </div>
                    <a href="{{ route('staff.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                        Back to Staff List
                    </a>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('staff.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Staff ID -->
                        <div>
                            <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Staff ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="staff_id" 
                                   name="staff_id" 
                                   value="{{ old('staff_id') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('staff_id') border-red-500 @enderror"
                                   placeholder="e.g., 104081"
                                   required>
                            @error('staff_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Staff Position -->
                        <div>
                            <label for="staff_position" class="block text-sm font-medium text-gray-700 mb-2">
                                Staff Position <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="staff_position" 
                                   name="staff_position" 
                                   value="{{ old('staff_position') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('staff_position') border-red-500 @enderror"
                                   placeholder="e.g., Branch Manager"
                                   required>
                            @error('staff_position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Staff Branch -->
                        <div>
                            <label for="staff_branch" class="block text-sm font-medium text-gray-700 mb-2">
                                Staff Branch <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="staff_branch" 
                                   name="staff_branch" 
                                   value="{{ old('staff_branch') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('staff_branch') border-red-500 @enderror"
                                   placeholder="e.g., KUALA LUMPUR SALES HUB"
                                   required>
                            @error('staff_branch')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                   placeholder="e.g., John Doe">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                   placeholder="e.g., john.doe@company.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                   placeholder="e.g., +60123456789">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('staff.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            Create Staff Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
