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
    .print-content {
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
    }
}
</style>
<script>
function testPrint() {
    console.log('Testing print functionality...');
    console.log('Printable area exists:', document.querySelector('.printable-area') !== null);
    console.log('Print CSS loaded:', window.getComputedStyle(document.body).getPropertyValue('visibility'));
    
    // Test if print function is available
    if (typeof window.print === 'function') {
        console.log('window.print() is available');
        window.print();
    } else {
        console.error('window.print() is not available');
        alert('Print function not available');
    }
}
</script>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Printable Area -->
                <div class="printable-area">
                    <!-- Print Header -->
                    <div class="print-header">
                        <h1 class="text-3xl font-bold text-gray-900">ANNULMENT INDIVIDUAL PROFILE</h1>
                        <p class="text-lg text-gray-600 mt-2">Insolvency Data System</p>
                        <p class="text-sm text-gray-500 mt-1">Generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <!-- Screen Header -->
                    <div class="no-print">
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
                    </div>

                    <!-- Annulment Individual Details Card -->
                    <div class="bg-gray-50 rounded-lg p-6 print-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Annulment Individual ID -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">Annulment Individual ID</label>
                                <p class="text-lg font-semibold text-blue-600 print-value">{{ $annulmentIndv->annulment_indv_id }}</p>
                            </div>

                            <!-- No Involvency -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">No Involvency</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->no_involvency ?? 'Not provided' }}</p>
                            </div>

                            <!-- Name -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">Name</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->name ?? 'Not provided' }}</p>
                            </div>

                            <!-- IC No -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">IC No</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->ic_no ?? 'Not provided' }}</p>
                            </div>

                            <!-- IC No 2 -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">IC No 2</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->ic_no_2 ?? 'Not provided' }}</p>
                            </div>

                            <!-- Court Case Number -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">Court Case Number</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->court_case_number ?? 'Not provided' }}</p>
                            </div>

                            <!-- RO Date -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">RO Date</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->ro_date ? $annulmentIndv->ro_date->format('d/m/Y') : 'Not provided' }}</p>
                            </div>

                            <!-- AO Date -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">AO Date</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->ao_date ? $annulmentIndv->ao_date->format('d/m/Y') : 'Not provided' }}</p>
                            </div>

                            <!-- Updated Date -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">Updated Date</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->updated_date ? $annulmentIndv->updated_date->format('d/m/Y') : 'Not provided' }}</p>
                            </div>

                            <!-- Branch Name -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">Branch Name</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->branch_name ?? 'Not provided' }}</p>
                            </div>

                            <!-- Created Date -->
                            <div class="print-field">
                                <label class="block text-sm font-medium text-gray-500 mb-1 print-label">Created Date</label>
                                <p class="text-lg font-semibold text-gray-900 print-value">{{ $annulmentIndv->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 p-6 bg-gray-50 border-2 border-gray-300 rounded-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Actions</h3>
                    <div class="flex justify-center space-x-6">
                        <!-- Print Button -->
                        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg transition duration-200 shadow-lg flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            PRINT
                        </button>
                        
                        <!-- Close Button -->
                        <button onclick="history.back()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-4 px-8 rounded-lg transition duration-200 shadow-lg flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            CLOSE
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mt-4 text-center">Click PRINT to print this page or CLOSE to close the window</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
