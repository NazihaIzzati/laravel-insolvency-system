@extends('layouts.app')

@section('content')
<div class="bg-white-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Upload Non-Individual Bankruptcy Data</h1>
                    <p class="mt-2 text-neutral-800">Add new non-individual bankruptcy record to the system</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('non-individual-bankruptcy.index') }}" 
                       class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('non-individual-bankruptcy.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-medium text-neutral-900 mb-4">Basic Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="insolvency_no" class="form-label">Insolvency Number *</label>
                                    <input type="text" 
                                           id="insolvency_no" 
                                           name="insolvency_no" 
                                           value="{{ old('insolvency_no') }}"
                                           class="form-input @error('insolvency_no') border-red-500 @enderror"
                                           placeholder="e.g., NINS001"
                                           required>
                                    @error('insolvency_no')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="company_name" class="form-label">Company Name *</label>
                                    <input type="text" 
                                           id="company_name" 
                                           name="company_name" 
                                           value="{{ old('company_name') }}"
                                           class="form-input @error('company_name') border-red-500 @enderror"
                                           placeholder="e.g., ABC Company Sdn Bhd"
                                           required>
                                    @error('company_name')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="company_registration_no" class="form-label">Company Registration Number *</label>
                                    <input type="text" 
                                           id="company_registration_no" 
                                           name="company_registration_no" 
                                           value="{{ old('company_registration_no') }}"
                                           class="form-input @error('company_registration_no') border-red-500 @enderror"
                                           placeholder="e.g., 123456789012"
                                           required>
                                    @error('company_registration_no')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="others" class="form-label">Others</label>
                                    <textarea id="others" 
                                              name="others" 
                                              rows="3"
                                              class="form-input @error('others') border-red-500 @enderror"
                                              placeholder="Additional information">{{ old('others') }}</textarea>
                                    @error('others')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Case Information -->
                        <div>
                            <h3 class="text-lg font-medium text-neutral-900 mb-4">Case Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="court_case_no" class="form-label">Court Case Number</label>
                                    <input type="text" 
                                           id="court_case_no" 
                                           name="court_case_no" 
                                           value="{{ old('court_case_no') }}"
                                           class="form-input @error('court_case_no') border-red-500 @enderror"
                                           placeholder="e.g., CASE2024001">
                                    @error('court_case_no')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="branch" class="form-label">Branch</label>
                                    <input type="text" 
                                           id="branch" 
                                           name="branch" 
                                           value="{{ old('branch') }}"
                                           class="form-input @error('branch') border-red-500 @enderror"
                                           placeholder="e.g., Kuala Lumpur Branch">
                                    @error('branch')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="date_of_winding_up_resolution" class="form-label">Date of Winding Up/Resolution</label>
                                    <input type="text" 
                                           id="date_of_winding_up_resolution" 
                                           name="date_of_winding_up_resolution" 
                                           value="{{ old('date_of_winding_up_resolution') }}"
                                           placeholder="Select Date"
                                           class="form-input @error('date_of_winding_up_resolution') border-red-500 @enderror">
                                    @error('date_of_winding_up_resolution')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="updated_date" class="form-label">Updated Date</label>
                                    <input type="text" 
                                           id="updated_date" 
                                           name="updated_date" 
                                           value="{{ old('updated_date') }}"
                                           placeholder="Select Date & Time"
                                           class="form-input @error('updated_date') border-red-500 @enderror">
                                    @error('updated_date')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 pt-6 border-t border-neutral-200 flex justify-end">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Upload Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr for date fields
    flatpickr("#date_of_winding_up_resolution", {
        dateFormat: "d/m/Y",
        allowInput: true,
        placeholder: "Select Date"
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
