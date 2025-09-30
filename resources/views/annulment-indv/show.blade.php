@extends('layouts.app')

@section('title', 'View Annulment Record')

@section('content')
<div class="min-h-screen bg-primary-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-primary-900">Annulment Record Details</h1>
                    <p class="text-primary-600 mt-2">View annulment individual record information</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('annulment-indv.edit', $annulmentIndv) }}" class="professional-button-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Record
                    </a>
                    <a href="{{ route('annulment-indv.index') }}" class="professional-button">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Records
                    </a>
                </div>
            </div>
        </div>

        <!-- Record Details Card -->
        <div class="bg-white shadow rounded-lg pdf-content">
            <div class="px-4 py-5 sm:p-6">
                <div class="pdf-record-grid">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $annulmentIndv->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">IC Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $annulmentIndv->ic_no }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Others</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $annulmentIndv->others ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Case Information -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Case Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Court Case Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $annulmentIndv->court_case_no ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Branch</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $annulmentIndv->branch ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($annulmentIndv->is_active)
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
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Important Dates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Release Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($annulmentIndv->release_date)
                                    @if(is_string($annulmentIndv->release_date))
                                        {{ \Carbon\Carbon::parse($annulmentIndv->release_date)->format('d/m/Y') }}
                                    @else
                                        {{ $annulmentIndv->release_date->format('d/m/Y') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Updated Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $annulmentIndv->formatted_updated_date }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Release Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $annulmentIndv->release_type ?? 'N/A' }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200 no-print">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <!-- Left side buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('annulment-indv.edit', $annulmentIndv) }}" 
                               class="professional-button-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Record
                            </a>
                            <button onclick="window.print()" class="professional-button">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print
                            </button>
                        </div>
                        
                        <!-- Right side buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('annulment-indv.index') }}" class="professional-button">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Records
                            </a>
                        </div>
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