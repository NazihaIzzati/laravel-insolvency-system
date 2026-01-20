@extends('layouts.app')

@section('title', 'Edit Annulment Record')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 no-print">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Edit Individual Annulment Record</h1>
                    <p class="mt-2 text-neutral-800">Update the individual annulment record information</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="px-8 py-8">
                <form method="POST" action="{{ route('annulment-indv.update', $annulmentIndv) }}" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Form Header -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Annulment Individual Information</h2>
                        <p class="text-gray-600">Update the details for {{ $annulmentIndv->name ?? 'this annulment record' }}</p>
                    </div>
                    
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $annulmentIndv->name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('name') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="e.g., Ahmad Rahman"
                                       required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ic_no" class="block text-sm font-semibold text-gray-700 mb-3">
                                    IC No <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="ic_no" 
                                       name="ic_no" 
                                       value="{{ old('ic_no', $annulmentIndv->ic_no) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('ic_no') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="e.g., 123456789012"
                                       required>
                                @error('ic_no')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="others" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Others
                                </label>
                                <input type="text" 
                                       id="others" 
                                       name="others" 
                                       value="{{ old('others', $annulmentIndv->others) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('others') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="Additional information">
                                @error('others')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="court_case_no" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Court Case No
                                </label>
                                <input type="text" 
                                       id="court_case_no" 
                                       name="court_case_no" 
                                       value="{{ old('court_case_no', $annulmentIndv->court_case_no) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('court_case_no') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="e.g., CC2024001">
                                @error('court_case_no')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dates and Additional Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Dates and Additional Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="release_date" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Release Date
                                </label>
                                <input type="text" 
                                       id="release_date" 
                                       name="release_date" 
                                       value="{{ old('release_date', $annulmentIndv->release_date ? $annulmentIndv->release_date->format('d/m/Y') : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('release_date') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="Select Release Date">
                                @error('release_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="updated_date" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Updated Date
                                </label>
                                <input type="text" 
                                       id="updated_date" 
                                       name="updated_date" 
                                       value="{{ old('updated_date', $annulmentIndv->formatted_updated_date) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('updated_date') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="Select Date & Time">
                                @error('updated_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="release_type" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Release Type
                                </label>
                                <input type="text" 
                                       id="release_type" 
                                       name="release_type" 
                                       value="{{ old('release_type', $annulmentIndv->release_type) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('release_type') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="e.g., Pelepasan Sijil KPI">
                                @error('release_type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="branch" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Branch
                                </label>
                                <input type="text" 
                                       id="branch" 
                                       name="branch" 
                                       value="{{ old('branch', $annulmentIndv->branch) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('branch') border-red-500 focus:ring-red-500 @enderror"
                                       placeholder="e.g., Pejabat Negeri Johor">
                                @error('branch')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-12 pt-8 border-t border-gray-200 no-print">
                        <div class="flex justify-end space-x-4">
                            <!-- Cancel Button -->
                            <a href="{{ route('annulment-indv.index') }}" 
                               class="px-6 py-3 bg-red-500 text-white text-sm font-semibold rounded-lg hover:bg-red-600 transition-colors duration-200">
                                Cancel
                            </a>
                            
                            <!-- Update Record Button -->
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-orange-500 text-white text-sm font-semibold rounded-lg hover:bg-orange-600 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Update Record
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr for date fields
    flatpickr("#release_date", {
        dateFormat: "d/m/Y",
        allowInput: true,
        placeholder: "Select Release Date"
    });
    
    flatpickr("#updated_date", {
        enableTime: true,
        dateFormat: "d/m/Y h:i A",
        allowInput: true,
        placeholder: "Select Date & Time"
    });
});
</script>
@endsection