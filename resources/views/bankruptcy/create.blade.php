@extends('layouts.app')

@section('title', 'Upload Bankruptcy Data')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Upload Bankruptcy Data</h1>
                    <p class="mt-1 text-sm text-gray-600">Add new bankruptcy person information to the database</p>
                </div>
                <a href="{{ route('bankruptcy.index') }}" class="btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="POST" action="{{ route('bankruptcy.store') }}" class="space-y-6">
                @csrf
                
                <!-- Required Fields -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Required Information</h3>
                    </div>
                    
                    <div>
                        <label for="insolvency_no" class="form-label">Insolvency No *</label>
                        <input type="text" id="insolvency_no" name="insolvency_no" 
                               class="form-input @error('insolvency_no') border-red-300 @enderror"
                               value="{{ old('insolvency_no') }}" required>
                        @error('insolvency_no')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" id="name" name="name" 
                               class="form-input @error('name') border-red-300 @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ic_no" class="form-label">IC No *</label>
                        <input type="text" id="ic_no" name="ic_no" 
                               class="form-input @error('ic_no') border-red-300 @enderror"
                               value="{{ old('ic_no') }}" required>
                        @error('ic_no')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="others" class="form-label">Others</label>
                        <input type="text" id="others" name="others" 
                               class="form-input @error('others') border-red-300 @enderror"
                               value="{{ old('others') }}">
                        @error('others')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Case Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Case Information</h3>
                    </div>
                    
                    <div>
                        <label for="court_case_no" class="form-label">Court Case No</label>
                        <input type="text" id="court_case_no" name="court_case_no" 
                               class="form-input @error('court_case_no') border-red-300 @enderror"
                               value="{{ old('court_case_no') }}">
                        @error('court_case_no')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="branch" class="form-label">Branch</label>
                        <input type="text" id="branch" name="branch" 
                               class="form-input @error('branch') border-red-300 @enderror"
                               value="{{ old('branch') }}">
                        @error('branch')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="sm:col-span-3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Important Dates</h3>
                    </div>
                    
                    <div>
                        <label for="ro_date" class="form-label">RO Date</label>
                        <input type="text" id="ro_date" name="ro_date" 
                               class="form-input @error('ro_date') border-red-300 @enderror"
                               value="{{ old('ro_date') }}" placeholder="Select date">
                        @error('ro_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ao_date" class="form-label">AO Date</label>
                        <input type="text" id="ao_date" name="ao_date" 
                               class="form-input @error('ao_date') border-red-300 @enderror"
                               value="{{ old('ao_date') }}" placeholder="Select date">
                        @error('ao_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="updated_date" class="form-label">Updated Date</label>
                        <input type="text" id="updated_date" name="updated_date" 
                               class="form-input @error('updated_date') border-red-300 @enderror"
                               value="{{ old('updated_date') }}" placeholder="Select Date & Time">
                        @error('updated_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('bankruptcy.index') }}" class="btn-outline">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Bankruptcy Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr for date fields
    flatpickr("#ro_date", {
        dateFormat: "Y-m-d",
        allowInput: true,
        placeholder: "Select RO Date"
    });
    
    flatpickr("#ao_date", {
        dateFormat: "Y-m-d",
        allowInput: true,
        placeholder: "Select AO Date"
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