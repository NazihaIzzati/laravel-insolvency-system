@extends('layouts.app')

@section('title', 'Non-Individual Annulment Record Details')

@section('content')
<div class="min-h-screen bg-neutral-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-neutral-900 to-accent-600 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-12">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-4xl font-light mb-3">Non-Individual Annulment Record</h1>
                        <p class="text-xl text-primary-100 mb-2">{{ $annulmentNonIndv->company_name }}</p>
                        <p class="text-primary-200">View company annulment details</p>
                    </div>
                    <div class="text-right text-white">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-6 py-4">
                            <p class="text-sm text-primary-100 mb-1">Insolvency No</p>
                            <p class="text-lg font-medium">{{ $annulmentNonIndv->insolvency_no }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="professional-section mb-6">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-neutral-900">Company Information</h3>
                <p class="text-sm text-neutral-700 mt-1">Complete company and annulment details</p>
            </div>
            <div class="professional-section-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Company Name -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full mr-3">
                                <i class="fas fa-building text-blue-600"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Company Name</h4>
                        </div>
                        <span class="pill-badge pill-badge-company">{{ $annulmentNonIndv->company_name ?? 'N/A' }}</span>
                    </div>

                    <!-- Insolvency Number -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full mr-3">
                                <i class="fas fa-file-alt text-green-600"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Insolvency Number</h4>
                        </div>
                        <p class="text-neutral-700 font-medium">{{ $annulmentNonIndv->insolvency_no ?? 'N/A' }}</p>
                    </div>

                    <!-- Company Registration Number -->
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-purple-100 rounded-full mr-3">
                                <i class="fas fa-certificate text-purple-600"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Registration Number</h4>
                        </div>
                        <span class="pill-badge pill-badge-registration">{{ $annulmentNonIndv->company_registration_no ?? 'N/A' }}</span>
                    </div>

                    <!-- Others -->
                    <div class="bg-gradient-to-r from-neutral-50 to-neutral-100 rounded-xl p-6 border border-neutral-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-neutral-100 rounded-full mr-3">
                                <i class="fas fa-tag text-neutral-800"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Others</h4>
                        </div>
                        <p class="text-neutral-700 font-medium">{{ $annulmentNonIndv->others ?? 'N/A' }}</p>
                    </div>

                    <!-- Court Case Number -->
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-6 border border-red-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-full mr-3">
                                <i class="fas fa-gavel text-red-600"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Court Case Number</h4>
                        </div>
                        <p class="text-neutral-700 font-medium">{{ $annulmentNonIndv->court_case_no ?? 'N/A' }}</p>
                    </div>

                    <!-- Release Date -->
                    <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl p-6 border border-teal-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-teal-100 rounded-full mr-3">
                                <i class="fas fa-calendar text-teal-600"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Release Date</h4>
                        </div>
                        <p class="text-neutral-700 font-medium">
                            @if($annulmentNonIndv->release_date)
                                @if(is_string($annulmentNonIndv->release_date))
                                    {{ \Carbon\Carbon::parse($annulmentNonIndv->release_date)->format('d/m/Y') }}
                                @else
                                    {{ $annulmentNonIndv->release_date->format('d/m/Y') }}
                                @endif
                            @else
                                N/A
                            @endif
                        </p>
                    </div>

                    <!-- Release Type -->
                    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-6 border border-indigo-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-indigo-100 rounded-full mr-3">
                                <i class="fas fa-list text-indigo-600"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Release Type</h4>
                        </div>
                        <p class="text-neutral-700 font-medium">{{ $annulmentNonIndv->release_type ?? 'N/A' }}</p>
                    </div>

                    <!-- Branch -->
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 border border-neutral-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-white rounded-full mr-3">
                                <i class="fas fa-map-marker-alt text-neutral-800"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Branch</h4>
                        </div>
                        <p class="text-neutral-700 font-medium">{{ $annulmentNonIndv->branch ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="professional-section mb-6">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-neutral-900">System Information</h3>
                <p class="text-sm text-neutral-700 mt-1">Record metadata and timestamps</p>
            </div>
            <div class="professional-section-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Updated Date -->
                    <div class="bg-gradient-to-r from-slate-50 to-gray-50 rounded-xl p-6 border border-slate-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-slate-100 rounded-full mr-3">
                                <i class="fas fa-clock text-slate-800"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Last Updated</h4>
                        </div>
                        <p class="text-neutral-700 font-medium">{{ $annulmentNonIndv->formatted_updated_date }}</p>
                    </div>

                    <!-- Created Date -->
                    <div class="bg-gradient-to-r from-slate-50 to-gray-50 rounded-xl p-6 border border-slate-200">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-slate-100 rounded-full mr-3">
                                <i class="fas fa-plus text-slate-800"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Created Date</h4>
                        </div>
                        <p class="text-neutral-700 font-medium">{{ $annulmentNonIndv->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('annulment-non-indv.index') }}" class="professional-button">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
            <a href="{{ route('annulment-non-indv.edit', $annulmentNonIndv) }}" class="professional-button-primary">
                <i class="fas fa-edit mr-2"></i>
                Edit Record
            </a>
        </div>
    </div>
</div>
@endsection
