@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Staff Profile Details</h2>
                        <p class="text-gray-600 mt-1">View staff member information</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('staff.edit', $staff) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            Edit Staff
                        </a>
                        <a href="{{ route('staff.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            Back to Staff List
                        </a>
                    </div>
                </div>

                <!-- Staff Details Card -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Staff ID -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Staff ID</label>
                            <p class="text-lg font-semibold text-blue-600">{{ $staff->staff_id }}</p>
                        </div>

                        <!-- Staff Position -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Staff Position</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $staff->staff_position }}</p>
                        </div>

                        <!-- Staff Branch -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Staff Branch</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $staff->staff_branch }}</p>
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $staff->name ?? 'Not provided' }}</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $staff->email ?? 'Not provided' }}</p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $staff->phone ?? 'Not provided' }}</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $staff->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $staff->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <!-- Created Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Created Date</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $staff->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-center space-x-4">
                    <a href="{{ route('staff.edit', $staff) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Edit Profile
                    </a>
                    <form method="POST" action="{{ route('staff.destroy', $staff) }}" class="inline" onsubmit="return confirm('Are you sure you want to deactivate this staff member?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                            Deactivate Staff
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
