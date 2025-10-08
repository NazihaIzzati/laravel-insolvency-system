@extends('layouts.app')

@section('content')
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .printable-area, .printable-area * {
        visibility: visible;
    }
    .printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
    .print-header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
    }
    .print-form {
        font-size: 12px;
        line-height: 1.4;
    }
    .print-field {
        margin-bottom: 15px;
        page-break-inside: avoid;
    }
    .print-label {
        font-weight: bold;
        color: #000;
        margin-bottom: 5px;
    }
    .print-value {
        color: #000;
        border-bottom: 1px solid #ccc;
        padding-bottom: 2px;
        min-height: 20px;
    }
}
</style>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-neutral-900">
                <!-- Printable Area -->
                <div class="printable-area">
                    <!-- Print Header -->
                    <div class="print-header">
                        <h1 class="text-3xl font-bold text-neutral-900">NEW ANNULMENT INDIVIDUAL FORM</h1>
                        <p class="text-lg text-neutral-800 mt-2">Insolvency Data System</p>
                        <p class="text-sm text-neutral-700 mt-1">Generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <!-- Screen Header -->
                    <div class="no-print">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-neutral-900">Add New Annulment Individual</h2>
                                <p class="text-neutral-800 mt-1">Create a new annulment individual profile</p>
                            </div>
                            <div class="flex space-x-3">
                                <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Print Form
                                </button>
                                <a href="{{ route('annulment-indv.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                    Back to Annulment Individual List
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('annulment-indv.store') }}" class="space-y-6 print-form">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Annulment Individual ID -->
                            <div class="print-field">
                                <label for="annulment_indv_id" class="block text-sm font-medium text-neutral-700 mb-2 print-label">
                                    Annulment Individual ID <span class="text-red-500 no-print">*</span>
                                </label>
                                <input type="text" 
                                       id="annulment_indv_id" 
                                       name="annulment_indv_id" 
                                       value="{{ old('annulment_indv_id') }}"
                                       class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('annulment_indv_id') border-red-500 @enderror print-value"
                                       placeholder="e.g., 104081"
                                       required>
                                @error('annulment_indv_id')
                                    <p class="mt-1 text-sm text-red-600 no-print">{{ $message }}</p>
                                @enderror
                            </div>

                        <!-- No Involvency -->
                        <div>
                            <label for="no_involvency" class="block text-sm font-medium text-neutral-700 mb-2">
                                No Involvency
                            </label>
                            <input type="text" 
                                   id="no_involvency" 
                                   name="no_involvency" 
                                   value="{{ old('no_involvency') }}"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('no_involvency') border-red-500 @enderror"
                                   placeholder="e.g., INV001">
                            @error('no_involvency')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                   placeholder="e.g., Ahmad Rahman"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- IC No -->
                        <div>
                            <label for="ic_no" class="block text-sm font-medium text-neutral-700 mb-2">
                                IC No
                            </label>
                            <input type="text" 
                                   id="ic_no" 
                                   name="ic_no" 
                                   value="{{ old('ic_no') }}"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ic_no') border-red-500 @enderror"
                                   placeholder="e.g., 123456789012">
                            @error('ic_no')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- IC No 2 -->
                        <div>
                            <label for="ic_no_2" class="block text-sm font-medium text-neutral-700 mb-2">
                                IC No 2
                            </label>
                            <input type="text" 
                                   id="ic_no_2" 
                                   name="ic_no_2" 
                                   value="{{ old('ic_no_2') }}"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ic_no_2') border-red-500 @enderror"
                                   placeholder="e.g., 987654321098">
                            @error('ic_no_2')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Court Case Number -->
                        <div>
                            <label for="court_case_number" class="block text-sm font-medium text-neutral-700 mb-2">
                                Court Case Number
                            </label>
                            <input type="text" 
                                   id="court_case_number" 
                                   name="court_case_number" 
                                   value="{{ old('court_case_number') }}"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('court_case_number') border-red-500 @enderror"
                                   placeholder="e.g., CC2024001">
                            @error('court_case_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- RO Date -->
                        <div>
                            <label for="ro_date" class="block text-sm font-medium text-neutral-700 mb-2">
                                RO Date
                            </label>
                            <input type="text" 
                                   id="ro_date" 
                                   name="ro_date" 
                                   value="{{ old('ro_date') }}"
                                   placeholder="Select RO Date"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ro_date') border-red-500 @enderror">
                            @error('ro_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- AO Date -->
                        <div>
                            <label for="ao_date" class="block text-sm font-medium text-neutral-700 mb-2">
                                AO Date
                            </label>
                            <input type="text" 
                                   id="ao_date" 
                                   name="ao_date" 
                                   value="{{ old('ao_date') }}"
                                   placeholder="Select AO Date"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ao_date') border-red-500 @enderror">
                            @error('ao_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Updated Date -->
                        <div>
                            <label for="updated_date" class="block text-sm font-medium text-neutral-700 mb-2">
                                Updated Date
                            </label>
                            <input type="text" 
                                   id="updated_date" 
                                   name="updated_date" 
                                   value="{{ old('updated_date') }}"
                                   placeholder="Select Date & Time"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('updated_date') border-red-500 @enderror">
                            @error('updated_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Branch Name -->
                        <div>
                            <label for="branch_name" class="block text-sm font-medium text-neutral-700 mb-2">
                                Branch Name
                            </label>
                            <input type="text" 
                                   id="branch_name" 
                                   name="branch_name" 
                                   value="{{ old('branch_name') }}"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('branch_name') border-red-500 @enderror"
                                   placeholder="e.g., Kuala Lumpur Branch">
                            @error('branch_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4 no-print">
                            <a href="{{ route('annulment-indv.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                Create Annulment Individual
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
