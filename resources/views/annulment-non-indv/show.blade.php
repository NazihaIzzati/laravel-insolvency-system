@extends('layouts.app')

@section('title', 'View Non-Individual Annulment Record')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 no-print">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Non-Individual Annulment Record Details</h1>
                    <p class="mt-2 text-neutral-800">View detailed information about the company annulment record</p>
                </div>
            </div>
        </div>

        <!-- Record Details Card -->
        <div class="bg-white shadow rounded-lg pdf-content">
            <div class="px-4 py-5 sm:p-6">
                <div class="pdf-record-grid">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-medium text-neutral-900 mb-4">Company Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Company Name</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $annulmentNonIndv->company_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Insolvency Number</dt>
                                <dd class="mt-1 text-sm text-neutral-900 font-mono">{{ $annulmentNonIndv->insolvency_no }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Registration Number</dt>
                                <dd class="mt-1 text-sm text-neutral-900 font-mono">{{ $annulmentNonIndv->company_registration_no }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Others</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $annulmentNonIndv->others ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Case Information -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-neutral-900 mb-4">Case Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Court Case Number</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $annulmentNonIndv->court_case_no ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Branch</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $annulmentNonIndv->branch ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-neutral-700">Release Type</dt>
                                <dd class="mt-1 text-sm text-neutral-900">{{ $annulmentNonIndv->release_type ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Dates Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-neutral-900 mb-4">Important Dates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-neutral-700">Release Date</dt>
                            <dd class="mt-1 text-sm text-neutral-900">
                                @if($annulmentNonIndv->release_date)
                                    @if(is_string($annulmentNonIndv->release_date))
                                        {{ \Carbon\Carbon::parse($annulmentNonIndv->release_date)->format('d/m/Y') }}
                                    @else
                                        {{ $annulmentNonIndv->release_date->format('d/m/Y') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-700">Updated Date</dt>
                            <dd class="mt-1 text-sm text-neutral-900">
                                {{ $annulmentNonIndv->formatted_updated_date }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-neutral-700">Created Date</dt>
                            <dd class="mt-1 text-sm text-neutral-900">{{ $annulmentNonIndv->created_at->format('d/m/Y h:i A') }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-neutral-200 no-print">
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <!-- Edit Record Button -->
                        <a href="{{ route('annulment-non-indv.edit', $annulmentNonIndv) }}" 
                           class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Record
                        </a>
                        
                        <!-- View All Records Button -->
                        <a href="{{ route('annulment-non-indv.index') }}" 
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

<style>
@media print {
    .no-print {
        display: none !important;
    }
    .pdf-content {
        box-shadow: none !important;
        border: none !important;
    }
    .pdf-record-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
}
</style>
@endsection
