@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Annulment Individual Profile Details</h2>
                        <p class="text-gray-600 mt-1">View annulment individual information</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('annulment-indv.edit', $annulmentIndv) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            Edit Annulment Individual
                        </a>
                        <a href="{{ route('annulment-indv.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            Back to Annulment Individual List
                        </a>
                    </div>
                </div>

                <!-- Annulment Individual Details Card -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Annulment Individual ID -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Annulment Individual ID</label>
                            <p class="text-lg font-semibold text-blue-600">{{ $annulmentIndv->annulment_indv_id }}</p>
                        </div>

                        <!-- Annulment Individual Position -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Annulment Individual Position</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->annulment_indv_position }}</p>
                        </div>

                        <!-- Annulment Individual Branch -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Annulment Individual Branch</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->annulment_indv_branch }}</p>
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->name ?? 'Not provided' }}</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->email ?? 'Not provided' }}</p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->phone ?? 'Not provided' }}</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $annulmentIndv->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $annulmentIndv->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <!-- Created Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Created Date</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-center space-x-4">
                    <a href="{{ route('annulment-indv.edit', $annulmentIndv) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Edit Profile
                    </a>
                    <form method="POST" action="{{ route('annulment-indv.destroy', $annulmentIndv) }}" class="inline" onsubmit="return confirm('Are you sure you want to deactivate this annulment individual?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                            Deactivate Annulment Individual
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
