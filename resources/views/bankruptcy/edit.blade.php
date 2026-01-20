@extends('layouts.app')

@section('content')
<div class="bg-white-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 no-print">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Edit Bankruptcy Record</h1>
                    <p class="mt-2 text-neutral-800">Update the bankruptcy record information</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="px-8 py-8">
                <form action="{{ route('bankruptcy.update', $bankruptcy) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Form Header -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Bankruptcy Individual Information</h2>
                        <p class="text-gray-600">Update the details for {{ $bankruptcy->name ?? 'this bankruptcy record' }}</p>
                    </div>
                    
                    <!-- Basic Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="insolvency_no" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Insolvency Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="insolvency_no" 
                                       name="insolvency_no" 
                                       value="{{ old('insolvency_no', $bankruptcy->insolvency_no) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('insolvency_no') border-red-500 focus:ring-red-500 @enderror" 
                                       placeholder="e.g., BP001234/2025"
                                       required>
                                @error('insolvency_no')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $bankruptcy->name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('name') border-red-500 focus:ring-red-500 @enderror" 
                                       placeholder="e.g., Ahmad Rahman"
                                       required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ic_no" class="block text-sm font-semibold text-gray-700 mb-3">
                                    IC Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="ic_no" 
                                       name="ic_no" 
                                       value="{{ old('ic_no', $bankruptcy->ic_no) }}"
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
                                       value="{{ old('others', $bankruptcy->others) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('others') border-red-500 focus:ring-red-500 @enderror" 
                                       placeholder="Additional information">
                                @error('others')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Case Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Case Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="court_case_no" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Court Case Number
                                </label>
                                <input type="text" 
                                       id="court_case_no" 
                                       name="court_case_no" 
                                       value="{{ old('court_case_no', $bankruptcy->court_case_no) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('court_case_no') border-red-500 focus:ring-red-500 @enderror" 
                                       placeholder="e.g., BA-29NCC-1234-01/2024">
                                @error('court_case_no')
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
                                       value="{{ old('branch', $bankruptcy->branch) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('branch') border-red-500 focus:ring-red-500 @enderror" 
                                       placeholder="e.g., Pejabat Negeri Selangor">
                                @error('branch')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dates Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Important Dates</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div>
                                <label for="ro_date" class="block text-sm font-semibold text-gray-700 mb-3">
                                    RO Date & Time
                                </label>
                                <input type="datetime-local" 
                                       id="ro_date" 
                                       name="ro_date" 
                                       value="{{ old('ro_date', $bankruptcy->ro_date ? $bankruptcy->ro_date->format('Y-m-d\TH:i') : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('ro_date') border-red-500 focus:ring-red-500 @enderror">
                                @error('ro_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ao_date" class="block text-sm font-semibold text-gray-700 mb-3">
                                    AO Date & Time
                                </label>
                                <input type="datetime-local" 
                                       id="ao_date" 
                                       name="ao_date" 
                                       value="{{ old('ao_date', $bankruptcy->ao_date ? $bankruptcy->ao_date->format('Y-m-d\TH:i') : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('ao_date') border-red-500 focus:ring-red-500 @enderror">
                                @error('ao_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="updated_date" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Updated Date & Time
                                </label>
                                <input type="datetime-local" 
                                       id="updated_date" 
                                       name="updated_date" 
                                       value="{{ old('updated_date', $bankruptcy->updated_at ? $bankruptcy->updated_at->format('Y-m-d\TH:i') : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('updated_date') border-red-500 focus:ring-red-500 @enderror">
                                @error('updated_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Status</h3>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $bankruptcy->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-neutral-800 focus:ring-neutral-500 border-neutral-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-neutral-900">
                                Active Record
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-neutral-700">Uncheck to deactivate this record</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-12 pt-8 border-t border-gray-200 no-print">
                        <div class="flex justify-end space-x-4">
                            <!-- Cancel Button -->
                            <a href="{{ route('bankruptcy.index') }}" 
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
    // Initialize Flatpickr for date and time fields with 12-hour format
    flatpickr("#ro_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: false,
        allowInput: true,
        placeholder: "Select RO Date & Time"
    });
    
    flatpickr("#ao_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: false,
        allowInput: true,
        placeholder: "Select AO Date & Time"
    });
    
    flatpickr("#updated_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: false,
        allowInput: true,
        placeholder: "Select Date & Time"
    });
});
</script>
@endsection
