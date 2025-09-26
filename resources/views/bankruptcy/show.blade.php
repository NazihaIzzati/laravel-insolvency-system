@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Print Header (only visible when printing) -->
        <div class="print-only" style="display: none;">
            <div class="pdf-header">
                <div class="pdf-logo-section">
                    <div class="pdf-logo">
                        <h1 class="pdf-company-name">BMMB Insolvency Data System</h1>
                        <p class="pdf-company-subtitle">Bankruptcy Record Report</p>
                    </div>
                </div>
                <div class="pdf-document-info">
                    <div class="pdf-document-title">BANKRUPTCY RECORD DETAILS</div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8 no-print">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Bankruptcy Record Details</h1>
                    <p class="mt-2 text-gray-600">View detailed information about the bankruptcy record</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('bankruptcy.index') }}" 
                       class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
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
                                <dt class="text-sm font-medium text-gray-500">Insolvency Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $bankruptcy->insolvency_no }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bankruptcy->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">IC Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $bankruptcy->ic_no }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Others</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bankruptcy->others ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Case Information -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Case Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Court Case Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bankruptcy->court_case_no ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Branch</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bankruptcy->branch ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($bankruptcy->is_active)
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
                            <dt class="text-sm font-medium text-gray-500">RO Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($bankruptcy->ro_date)
                                    @if(is_string($bankruptcy->ro_date))
                                        {{ \Carbon\Carbon::parse($bankruptcy->ro_date)->format('d/m/Y') }}
                                    @else
                                        {{ $bankruptcy->ro_date->format('d/m/Y') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">AO Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($bankruptcy->ao_date)
                                    @if(is_string($bankruptcy->ao_date))
                                        {{ \Carbon\Carbon::parse($bankruptcy->ao_date)->format('d/m/Y') }}
                                    @else
                                        {{ $bankruptcy->ao_date->format('d/m/Y') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Updated Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($bankruptcy->updated_date)
                                    @if(is_string($bankruptcy->updated_date))
                                        {{ \Carbon\Carbon::parse($bankruptcy->updated_date)->format('d/m/Y g:i A') }}
                                    @else
                                        {{ $bankruptcy->updated_date->format('d/m/Y g:i A') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                    </div>
                </div>


                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200 no-print">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <!-- Left side buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('bankruptcy.edit', $bankruptcy) }}" 
                               class="btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Record
                            </a>
                            <a href="{{ route('bankruptcy.index') }}" 
                               class="btn-secondary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                View All Records
                            </a>
                        </div>
                        
                        <!-- Right side - Print button -->
                        <button onclick="window.print()" class="btn-outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print Record
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
