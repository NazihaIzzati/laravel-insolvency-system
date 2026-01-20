@extends('layouts.app')

@section('content')
<div class="bg-white-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Print Header (only visible when printing) -->
        <div class="print-only" style="display: none;">
            <div class="pdf-header">
                <div class="pdf-logo-section">
                    <div class="pdf-logo">
                        <h1 class="pdf-company-name">BMMB Insolvency Information System</h1>
                        <p class="pdf-company-subtitle">Non-Individual Bankruptcy Record Report</p>
                    </div>
                </div>
                <div class="pdf-document-info">
                    <div class="pdf-document-title">NON-INDIVIDUAL BANKRUPTCY RECORD DETAILS</div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8 no-print">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Non-Individual Bankruptcy Record Details</h1>
                    <p class="mt-2 text-neutral-800">View detailed information about the non-individual bankruptcy record</p>
                </div>
            </div>
        </div>

        <!-- Record Details Card -->
        <div class="bg-white shadow rounded-lg pdf-content">
            <div class="px-4 py-5 sm:p-6">
                <div class="pdf-record-grid">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-medium text-neutral-900 mb-4">Basic Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Insolvency Number</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $nonIndividualBankruptcy->insolvency_no }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Company Name</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $nonIndividualBankruptcy->company_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Company Registration Number</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $nonIndividualBankruptcy->company_registration_no }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Others</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $nonIndividualBankruptcy->others ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Case Information -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-neutral-900 mb-4">Case Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Court Case Number</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $nonIndividualBankruptcy->court_case_no ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Branch</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $nonIndividualBankruptcy->branch ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Status</dt>
                                <dd class="mt-1">
                                    @if($nonIndividualBankruptcy->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Dates Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-neutral-900 mb-4">Important Dates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-neutral-700">Date of Winding Up/Resolution</dt>
                            <dd class="mt-1 text-sm text-neutral-900">
                                @if($nonIndividualBankruptcy->date_of_winding_up_resolution)
                                    @if(is_string($nonIndividualBankruptcy->date_of_winding_up_resolution))
                                        {{ \Carbon\Carbon::parse($nonIndividualBankruptcy->date_of_winding_up_resolution)->format('d/m/Y') }}
                                    @else
                                        {{ $nonIndividualBankruptcy->date_of_winding_up_resolution->format('d/m/Y') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-700">Updated Date</dt>
                            <dd class="mt-1 text-sm text-neutral-900">
                                {{ $nonIndividualBankruptcy->formatted_updated_date }}
                            </dd>
                        </div>
                    </div>
                </div>


                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-neutral-200 no-print">
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <!-- Edit Record Button -->
                        <a href="{{ route('non-individual-bankruptcy.edit', $nonIndividualBankruptcy) }}" 
                           class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Record
                        </a>
                        
                        <!-- View All Records Button -->
                        <a href="{{ route('non-individual-bankruptcy.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            View All Records
                        </a>
                        
                        <!-- Print Record Button -->
                        <button onclick="window.print()" 
                                class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print Record
                        </button>
                        
                        <!-- Close Button -->
                        <button onclick="history.back()" 
                                class="inline-flex items-center px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
