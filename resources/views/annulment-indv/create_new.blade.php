@extends('layouts.app')

@section('title', 'Add New Annulment Record')

@section('content')
<div class="min-h-screen bg-neutral-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Add New Annulment Record</h1>
                    <p class="text-neutral-800 mt-2">Create a new annulment individual record</p>
                </div>
                <a href="{{ route('annulment-indv.index') }}" class="professional-button">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Records
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-neutral-900">Annulment Information</h3>
                <p class="text-sm text-neutral-700 mt-1">Enter the annulment details</p>
            </div>
            <div class="professional-section-content">
                <form method="POST" action="{{ route('annulment-indv.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div>
                        <h4 class="text-md font-medium text-neutral-800 mb-4">Basic Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="form-label">Name <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       class="form-input @error('name') border-red-300 @enderror"
                                       placeholder="e.g., Ahmad Rahman"
                                       required>
                                @error('name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ic_no" class="form-label">IC No <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="ic_no" 
                                       name="ic_no" 
                                       value="{{ old('ic_no') }}"
                                       class="form-input @error('ic_no') border-red-300 @enderror"
                                       placeholder="e.g., 123456789012"
                                       required>
                                @error('ic_no')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="others" class="form-label">Others</label>
                                <input type="text" 
                                       id="others" 
                                       name="others" 
                                       value="{{ old('others') }}"
                                       class="form-input @error('others') border-red-300 @enderror"
                                       placeholder="Additional information">
                                @error('others')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="court_case_no" class="form-label">Court Case No</label>
                                <input type="text" 
                                       id="court_case_no" 
                                       name="court_case_no" 
                                       value="{{ old('court_case_no') }}"
                                       class="form-input @error('court_case_no') border-red-300 @enderror"
                                       placeholder="e.g., CC2024001">
                                @error('court_case_no')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dates and Additional Information -->
                    <div>
                        <h4 class="text-md font-medium text-neutral-800 mb-4">Dates and Additional Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="release_date" class="form-label">Release Date</label>
                                <input type="text" 
                                       id="release_date" 
                                       name="release_date" 
                                       value="{{ old('release_date') }}"
                                       class="form-input @error('release_date') border-red-300 @enderror"
                                       placeholder="Select Release Date">
                                @error('release_date')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="updated_date" class="form-label">Updated Date</label>
                                <input type="text" 
                                       id="updated_date" 
                                       name="updated_date" 
                                       value="{{ old('updated_date') }}"
                                       class="form-input @error('updated_date') border-red-300 @enderror"
                                       placeholder="Select Date & Time">
                                @error('updated_date')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="release_type" class="form-label">Release Type</label>
                                <input type="text" 
                                       id="release_type" 
                                       name="release_type" 
                                       value="{{ old('release_type') }}"
                                       class="form-input @error('release_type') border-red-300 @enderror"
                                       placeholder="e.g., Pelepasan Sijil KPI">
                                @error('release_type')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="branch" class="form-label">Branch</label>
                                <input type="text" 
                                       id="branch" 
                                       name="branch" 
                                       value="{{ old('branch') }}"
                                       class="form-input @error('branch') border-red-300 @enderror"
                                       placeholder="e.g., Pejabat Negeri Johor">
                                @error('branch')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('annulment-indv.index') }}" class="btn-outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Annulment Record
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
