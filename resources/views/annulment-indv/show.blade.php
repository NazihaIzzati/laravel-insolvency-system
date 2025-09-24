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
                <div class="mt-8 p-4 bg-yellow-100 border-2 border-yellow-400 rounded-lg">
                    <h3 class="text-lg font-bold text-yellow-800 mb-4 text-center">Action Buttons</h3>
                    <div class="flex justify-center space-x-4 flex-wrap">
                        <button onclick="console.log('Print button clicked'); window.print();" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200 shadow-lg">
                            PRINT
                        </button>
                        <button onclick="testPrint()" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200 shadow-lg">
                            TEST PRINT
                        </button>
                        <a href="{{ route('annulment-indv.edit', $annulmentIndv) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200 shadow-lg no-print">
                            EDIT PROFILE
                        </a>
                        <form method="POST" action="{{ route('annulment-indv.destroy', $annulmentIndv) }}" class="inline no-print" onsubmit="return confirm('Are you sure you want to delete this annulment individual?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200 shadow-lg">
                                DELETE
                            </button>
                        </form>
                    </div>
                    <p class="text-sm text-yellow-700 mt-2 text-center">If you can see this yellow box, the buttons should be visible above!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
