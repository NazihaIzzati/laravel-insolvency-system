@extends('layouts.app')

@section('title', 'Non-Individual Bankruptcy')

@section('content')
<div class="min-h-screen bg-primary-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary-900 to-accent-600 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-12">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-4xl font-light mb-3">Non-Individual Bankruptcy</h1>
                        <p class="text-xl text-primary-100 mb-2">Manage company bankruptcy records</p>
                        <p class="text-primary-200">Track and manage all company bankruptcy cases</p>
                    </div>
                    <div class="text-right text-white">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-6 py-4">
                            <p class="text-sm text-primary-100 mb-1">Total Records</p>
                            <p class="text-lg font-medium">{{ $nonIndividualBankruptcies->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="professional-section mb-6">
            <div class="professional-section-content">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('non-individual-bankruptcy.create') }}" class="professional-button-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Record
                    </a>
                    <a href="{{ route('non-individual-bankruptcy.bulk-upload') }}" class="professional-button">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Bulk Upload
                    </a>
                    @if($nonIndividualBankruptcies->count() > 0)
                        <a href="{{ route('non-individual-bankruptcy.download') }}" class="professional-button">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Excel
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Records Table -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-primary-900">Non-Individual Bankruptcy Records</h3>
                <p class="text-sm text-primary-500 mt-1">All company and organization bankruptcy records</p>
            </div>
            <div class="professional-section-content">
            @if($nonIndividualBankruptcies->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Insolvency No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company Registration No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Others</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Court Case No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Winding Up/Resolution</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Branch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($nonIndividualBankruptcies as $nonIndividualBankruptcy)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                        {{ $nonIndividualBankruptcy->insolvency_no }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $nonIndividualBankruptcy->company_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                        {{ $nonIndividualBankruptcy->company_registration_no }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $nonIndividualBankruptcy->others ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $nonIndividualBankruptcy->court_case_no ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($nonIndividualBankruptcy->date_of_winding_up_resolution && !empty(trim($nonIndividualBankruptcy->date_of_winding_up_resolution)))
                                            @if(is_string($nonIndividualBankruptcy->date_of_winding_up_resolution))
                                                {{ \Carbon\Carbon::parse($nonIndividualBankruptcy->date_of_winding_up_resolution)->format('d/m/Y') }}
                                            @else
                                                {{ $nonIndividualBankruptcy->date_of_winding_up_resolution->format('d/m/Y') }}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($nonIndividualBankruptcy->updated_date && !empty(trim($nonIndividualBankruptcy->updated_date)))
                                            @if(is_string($nonIndividualBankruptcy->updated_date))
                                                {{ \Carbon\Carbon::parse($nonIndividualBankruptcy->updated_date)->format('d/m/Y g:i A') }}
                                            @else
                                                {{ $nonIndividualBankruptcy->updated_date->format('d/m/Y g:i A') }}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $nonIndividualBankruptcy->branch ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('non-individual-bankruptcy.show', $nonIndividualBankruptcy) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">
                                                View
                                            </a>
                                            <a href="{{ route('non-individual-bankruptcy.edit', $nonIndividualBankruptcy) }}" 
                                               class="text-yellow-600 hover:text-yellow-900">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('non-individual-bankruptcy.destroy', $nonIndividualBankruptcy) }}" 
                                                  class="inline" onsubmit="return confirm('Are you sure you want to deactivate this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Deactivate
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $nonIndividualBankruptcies->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No non-individual bankruptcy records</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by uploading new data.</p>
                    <div class="mt-6">
                        <a href="{{ route('non-individual-bankruptcy.create') }}" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Upload New Data
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
