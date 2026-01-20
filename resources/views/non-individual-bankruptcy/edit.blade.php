@extends('layouts.app')

@section('content')
<div class="bg-white-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 no-print">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Edit Non-Individual Bankruptcy Record</h1>
                    <p class="mt-2 text-neutral-800">Update the non-individual bankruptcy record information</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="px-8 py-8">
                <form method="POST" action="{{ route('non-individual-bankruptcy.update', $nonIndividualBankruptcy) }}" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Form Header -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Bankruptcy Non-Individual Information</h2>
                        <p class="text-gray-600">Update the details for {{ $nonIndividualBankruptcy->company_name ?? 'this bankruptcy record' }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <label for="insolvency_no" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Insolvency Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="insolvency_no" 
                                           name="insolvency_no" 
                                           value="{{ old('insolvency_no', $nonIndividualBankruptcy->insolvency_no) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('insolvency_no') border-red-500 focus:ring-red-500 @enderror"
                                           placeholder="e.g., NINS001"
                                           required>
                                    @error('insolvency_no')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Company Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="company_name" 
                                           name="company_name" 
                                           value="{{ old('company_name', $nonIndividualBankruptcy->company_name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('company_name') border-red-500 focus:ring-red-500 @enderror"
                                           placeholder="e.g., ABC Company Sdn Bhd"
                                           required>
                                    @error('company_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="company_registration_no" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Company Registration Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="company_registration_no" 
                                           name="company_registration_no" 
                                           value="{{ old('company_registration_no', $nonIndividualBankruptcy->company_registration_no) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('company_registration_no') border-red-500 focus:ring-red-500 @enderror"
                                           placeholder="e.g., 123456789012"
                                           required>
                                    @error('company_registration_no')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="others" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Others
                                    </label>
                                    <textarea id="others" 
                                              name="others" 
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('others') border-red-500 focus:ring-red-500 @enderror"
                                              placeholder="Additional information">{{ old('others', $nonIndividualBankruptcy->others) }}</textarea>
                                    @error('others')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Case Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Case Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <label for="court_case_no" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Court Case Number
                                    </label>
                                    <input type="text" 
                                           id="court_case_no" 
                                           name="court_case_no" 
                                           value="{{ old('court_case_no', $nonIndividualBankruptcy->court_case_no) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('court_case_no') border-red-500 focus:ring-red-500 @enderror"
                                           placeholder="e.g., CASE2024001">
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
                                           value="{{ old('branch', $nonIndividualBankruptcy->branch) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('branch') border-red-500 focus:ring-red-500 @enderror"
                                           placeholder="e.g., Kuala Lumpur Branch">
                                    @error('branch')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="date_of_winding_up_resolution" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Date of Winding Up/Resolution & Time
                                    </label>
                                    <input type="datetime-local" 
                                           id="date_of_winding_up_resolution" 
                                           name="date_of_winding_up_resolution" 
                                           value="{{ old('date_of_winding_up_resolution', $nonIndividualBankruptcy->date_of_winding_up_resolution ? (is_string($nonIndividualBankruptcy->date_of_winding_up_resolution) ? \Carbon\Carbon::createFromFormat('d/m/Y h:i A', $nonIndividualBankruptcy->date_of_winding_up_resolution)->format('Y-m-d\TH:i') : $nonIndividualBankruptcy->date_of_winding_up_resolution->format('Y-m-d\TH:i')) : '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('date_of_winding_up_resolution') border-red-500 focus:ring-red-500 @enderror">
                                    @error('date_of_winding_up_resolution')
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
                                           value="{{ old('updated_date', $nonIndividualBankruptcy->updated_date ? (is_string($nonIndividualBankruptcy->updated_date) ? \Carbon\Carbon::createFromFormat('d/m/Y h:i A', $nonIndividualBankruptcy->updated_date)->format('Y-m-d\TH:i') : $nonIndividualBankruptcy->updated_date->format('Y-m-d\TH:i')) : '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200 @error('updated_date') border-red-500 focus:ring-red-500 @enderror">
                                    @error('updated_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-12 pt-8 border-t border-gray-200 no-print">
                        <div class="flex justify-end space-x-4">
                            <!-- Cancel Button -->
                            <a href="{{ route('non-individual-bankruptcy.index') }}" 
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
    flatpickr("#date_of_winding_up_resolution", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: false,
        allowInput: true,
        placeholder: "Select Date & Time"
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
