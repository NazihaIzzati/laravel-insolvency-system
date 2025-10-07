@extends('layouts.app')

@section('title', 'Non-Individual Annulment Records')

@section('content')
<div class="min-h-screen bg-primary-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary-900 to-accent-600 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-12">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-4xl font-light mb-3">Non-Individual Annulment Records</h1>
                        <p class="text-xl text-primary-100 mb-2">Manage annulment company profiles</p>
                        <p class="text-primary-200">Track and manage all non-individual annulment cases</p>
                    </div>
                    <div class="text-right text-white">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-6 py-4">
                            <p class="text-sm text-primary-100 mb-1">Total Records</p>
                            <p class="text-lg font-medium">{{ $annulmentNonIndv->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="professional-section mb-6">
            <div class="professional-section-content">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('annulment-non-indv.create') }}" class="professional-button-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Record
                        </a>
                        <a href="{{ route('annulment-non-indv.bulk-upload') }}" class="professional-button-accent">
                            <i class="fas fa-upload mr-2"></i>
                            Bulk Upload
                        </a>
                        @if($annulmentNonIndv->total() > 0)
                            <a href="{{ route('annulment-non-indv.download') }}" class="professional-button-success">
                                <i class="fas fa-download mr-2"></i>
                                Download Excel
                            </a>
                        @endif
                    </div>
                    <div class="flex gap-3 items-center">
                        <div class="flex items-center gap-2">
                            <label for="per_page" class="text-sm font-medium text-primary-700">Records per page:</label>
                            <select id="per_page" name="per_page" class="professional-input py-1 px-2 text-sm" onchange="changePerPage(this.value)">
                                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <a href="{{ route('dashboard') }}" class="professional-button">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Records Table -->
        <!-- Quick Search Section - Completely separate from cards -->
        <div class="bg-gradient-to-r from-accent-50 to-primary-50 p-8 mb-6 border-l-4 border-accent-500">
            <div class="flex items-center mb-6">
                <div class="flex items-center justify-center w-12 h-12 bg-accent-100 rounded-full mr-4">
                    <i class="fas fa-search text-accent-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-900">Quick Search</h4>
                    <p class="text-sm text-gray-600 mt-1">Find non-individual annulment records instantly</p>
                </div>
            </div>
            
            <form id="annulmentNonIndvSearchForm" class="space-y-6">
                @csrf
                <div>
                    <label for="annulment_non_indv_search_input" class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        Search Records
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-lg"></i>
                        </div>
                        <input type="text" 
                               id="annulment_non_indv_search_input" 
                               name="search_input" 
                               class="block w-full pl-12 pr-16 py-4 border-2 border-gray-200 rounded-xl text-base placeholder-gray-400 focus:border-accent-500 focus:ring-4 focus:ring-accent-100 focus:outline-none transition-all duration-300 bg-white shadow-sm hover:shadow-md" 
                               placeholder="Enter company name, registration no, court case number, or other reference..."
                               required>
                        <button type="button" id="clearAnnulmentNonIndvSearchBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-all duration-200 p-2 rounded-full hover:bg-gray-100 cursor-pointer z-10" style="display: none;" title="Clear search">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-building mr-2"></i>
                            Company Names
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-certificate mr-2"></i>
                            Registration Numbers
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <i class="fas fa-gavel mr-2"></i>
                            Court Cases
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <i class="fas fa-tag mr-2"></i>
                            References
                        </span>
                    </div>
                </div>
                
                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-blue-200">
                        <i class="fas fa-search mr-2"></i>
                        Search Records
                    </button>
                </div>
            </form>
        </div>

        <!-- Enhanced Loading Spinner -->
        <div id="annulmentNonIndvLoadingSpinner" class="hidden bg-white p-8 mb-6 border-l-4 border-blue-500">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-accent-100 to-primary-100 rounded-full mb-4">
                    <i class="fas fa-spinner fa-spin text-accent-600 text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Searching Records</h3>
                <p class="text-sm text-gray-600 mb-4">Please wait while we search for matching non-individual annulment records...</p>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-accent-500 to-primary-500 h-2 rounded-full animate-pulse" style="width: 60%"></div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Search Results -->
        <div id="annulmentNonIndvSearchResults" class="hidden bg-white mb-6">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-8 py-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mr-4">
                            <i class="fas fa-check-circle text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Search Results</h3>
                            <p class="text-sm text-gray-600 mt-1">Matching non-individual annulment records found</p>
                        </div>
                    </div>
                    <button type="button" id="clearAnnulmentNonIndvSearchResultsBtn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Clear Results
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto bg-gray-50 px-8 py-6">
                <table class="w-full divide-y divide-gray-200" style="min-width: 1000px;">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-48">Company Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Registration No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Others</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Court Case</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-24">Release Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Release Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Branch</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="annulmentNonIndvSearchResultsBody" class="bg-white divide-y divide-gray-200">
                        <!-- Results will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No Results Section -->
        <div id="annulmentNonIndvNoResults" class="hidden bg-white p-8 mb-6 border-l-4 border-gray-400">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-search text-gray-400 text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No Results Found</h3>
                <p class="text-sm text-gray-600 mb-4">We couldn't find any records matching your search criteria.</p>
                <button id="clearAnnulmentNonIndvNoResultsBtn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-accent-600 rounded hover:bg-accent-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Try Different Search
                </button>
            </div>
        </div>

        <!-- Divider between search and main content -->
        <div class="border-t border-gray-200 mb-8"></div>

        <!-- Main Content Card -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-primary-900">Non-Individual Annulment Records</h3>
                <p class="text-sm text-primary-500 mt-1">All non-individual annulment company profiles</p>
            </div>
            <div class="professional-section-content">

                <!-- Main Records Table -->
                <div id="mainAnnulmentNonIndvRecordsTable">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-primary-200" style="min-width: 1200px;">
                        <style>
                            .action-buttons {
                                position: sticky;
                                right: 0;
                                background-color: white;
                                z-index: 10;
                            }
                        </style>
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-48">Company Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Registration No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Others</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Court Case</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-24">Release Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-32">Updated Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Release Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Branch</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40 action-buttons">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-primary-200">
                            @forelse($annulmentNonIndv as $annulment)
                                <tr class="hover:bg-primary-50 transition-colors duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->company_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->company_registration_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->others ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->court_case_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">
                                            @if($annulment->release_date)
                                                @if(is_string($annulment->release_date))
                                                    {{ \Carbon\Carbon::parse($annulment->release_date)->format('d/m/Y') }}
                                                @else
                                                    {{ $annulment->release_date->format('d/m/Y') }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->formatted_updated_date }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->release_type ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->branch ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium action-buttons">
                                        <div class="flex flex-col space-y-1">
                                            <a href="{{ route('annulment-non-indv.show', $annulment) }}" class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-blue-600 rounded hover:bg-blue-700 transition-colors duration-200 w-fit">
                                                <i class="fas fa-eye mr-1"></i>
                                                View
                                            </a>
                                            <a href="{{ route('annulment-non-indv.edit', $annulment) }}" class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-green-600 rounded hover:bg-green-700 transition-colors duration-200 w-fit">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('annulment-non-indv.destroy', $annulment) }}" class="inline" onsubmit="return confirmDeleteAnnulmentNonIndv(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-red-600 rounded hover:bg-red-700 transition-colors duration-200 w-fit">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-primary-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="mx-auto h-12 w-12 text-primary-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <p class="text-sm font-medium">No non-individual annulment records found</p>
                                            <p class="text-xs text-primary-400 mt-1">
                                                <a href="{{ route('annulment-non-indv.create') }}" class="text-accent-600 hover:text-accent-700">Add the first record</a>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($annulmentNonIndv->hasPages())
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-primary-600">
                            Showing {{ $annulmentNonIndv->firstItem() }} to {{ $annulmentNonIndv->lastItem() }} of {{ $annulmentNonIndv->total() }} results
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $annulmentNonIndv->links() }}
                        </div>
                    </div>
                @endif
                </div> <!-- End mainAnnulmentNonIndvRecordsTable -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const annulmentNonIndvSearchForm = document.getElementById('annulmentNonIndvSearchForm');
    const annulmentNonIndvSearchInput = document.getElementById('annulment_non_indv_search_input');
    const clearAnnulmentNonIndvSearchBtn = document.getElementById('clearAnnulmentNonIndvSearchBtn');
    const annulmentNonIndvLoadingSpinner = document.getElementById('annulmentNonIndvLoadingSpinner');
    const annulmentNonIndvSearchResults = document.getElementById('annulmentNonIndvSearchResults');
    const annulmentNonIndvSearchResultsBody = document.getElementById('annulmentNonIndvSearchResultsBody');
    const annulmentNonIndvNoResults = document.getElementById('annulmentNonIndvNoResults');
    const clearAnnulmentNonIndvSearchResultsBtn = document.getElementById('clearAnnulmentNonIndvSearchResultsBtn');
    const mainAnnulmentNonIndvRecordsTable = document.getElementById('mainAnnulmentNonIndvRecordsTable');

    // Handle form submission
    annulmentNonIndvSearchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Search form submitted!'); // Debug log
        
        const searchValue = annulmentNonIndvSearchInput.value.trim();
        
        if (!searchValue) {
            Swal.fire({
                title: 'Error!',
                text: 'Please enter a search value.',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Show loading spinner
        annulmentNonIndvLoadingSpinner.classList.remove('hidden');
        annulmentNonIndvSearchResults.classList.add('hidden');
        annulmentNonIndvNoResults.classList.add('hidden');
        mainAnnulmentNonIndvRecordsTable.classList.add('hidden');

        // Make AJAX request
        fetch('{{ route("annulment-non-indv.search") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                search_input: searchValue
            })
        })
        .then(response => response.json())
        .then(data => {
            annulmentNonIndvLoadingSpinner.classList.add('hidden');
            
            if (data.success && data.results.length > 0) {
                displayAnnulmentNonIndvSearchResults(data.results);
            } else {
                showAnnulmentNonIndvNoResults();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            annulmentNonIndvLoadingSpinner.classList.add('hidden');
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while searching. Please try again.',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK'
            });
        });
    });

    // Handle clear search button
    clearAnnulmentNonIndvSearchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        clearAnnulmentNonIndvSearch();
    });

    // Handle clear search results button
    clearAnnulmentNonIndvSearchResultsBtn.addEventListener('click', function(e) {
        e.preventDefault();
        clearAnnulmentNonIndvSearch();
    });

    // Handle clear search from no results button
    const clearAnnulmentNonIndvSearchFromNoResults = document.getElementById('clearAnnulmentNonIndvSearchFromNoResults');
    if (clearAnnulmentNonIndvSearchFromNoResults) {
        clearAnnulmentNonIndvSearchFromNoResults.addEventListener('click', function(e) {
            e.preventDefault();
            clearAnnulmentNonIndvSearch();
        });
    }

    // Handle input changes to show/hide clear button
    annulmentNonIndvSearchInput.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            clearAnnulmentNonIndvSearchBtn.style.display = 'block';
        } else {
            clearAnnulmentNonIndvSearchBtn.style.display = 'none';
        }
    });

    function clearAnnulmentNonIndvSearch() {
        annulmentNonIndvSearchInput.value = '';
        clearAnnulmentNonIndvSearchBtn.style.display = 'none';
        annulmentNonIndvSearchResults.classList.add('hidden');
        annulmentNonIndvNoResults.classList.add('hidden');
        mainAnnulmentNonIndvRecordsTable.classList.remove('hidden');
    }

    function displayAnnulmentNonIndvSearchResults(results) {
        annulmentNonIndvSearchResultsBody.innerHTML = '';
        
        // Update results count in header
        const resultsCount = results.length;
        const resultsHeader = annulmentNonIndvSearchResults.querySelector('h3');
        const resultsSubtext = annulmentNonIndvSearchResults.querySelector('p');
        
        if (resultsCount === 1) {
            resultsHeader.textContent = 'Search Results';
            resultsSubtext.textContent = '1 matching non-individual annulment record found';
        } else {
            resultsHeader.textContent = 'Search Results';
            resultsSubtext.textContent = `${resultsCount} matching non-individual annulment records found`;
        }
        
        results.forEach((result, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-300 border-b border-gray-100';
            
            // Add alternating row colors
            if (index % 2 === 0) {
                row.classList.add('bg-white');
            } else {
                row.classList.add('bg-gray-50');
            }
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                <span class="text-xs font-bold text-white">${(result.company_name || 'N/A').charAt(0).toUpperCase()}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-bold text-gray-900">${result.company_name || 'N/A'}</div>
                            <div class="text-xs text-gray-500">Non-Individual Annulment</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 bg-blue-50 px-2 py-1 rounded inline-block">${result.company_registration_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${result.others || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 bg-purple-50 px-2 py-1 rounded inline-block">${result.court_case_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        ${result.release_date ? 
                            `<span class="bg-green-50 text-green-800 px-2 py-1 rounded text-xs font-medium">${new Date(result.release_date).toLocaleDateString()}</span>` : 
                            '<span class="text-gray-400">N/A</span>'
                        }
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        ${result.release_type ? 
                            `<span class="bg-orange-50 text-orange-800 px-2 py-1 rounded text-xs font-medium">${result.release_type}</span>` : 
                            '<span class="text-gray-400">N/A</span>'
                        }
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${result.branch || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex flex-col space-y-1">
                        <a href="/annulment-non-indv/${result.id}" class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-blue-600 rounded hover:bg-blue-700 transition-colors duration-200 w-fit">
                            <i class="fas fa-eye mr-1"></i>
                            View
                        </a>
                        <a href="/annulment-non-indv/${result.id}/edit" class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-green-600 rounded hover:bg-green-700 transition-colors duration-200 w-fit">
                            <i class="fas fa-edit mr-1"></i>
                            Edit
                        </a>
                    </div>
                </td>
            `;
            
            annulmentNonIndvSearchResultsBody.appendChild(row);
        });
        
        annulmentNonIndvSearchResults.classList.remove('hidden');
    }

    function showAnnulmentNonIndvNoResults() {
        annulmentNonIndvNoResults.classList.remove('hidden');
    }
});

function confirmDeleteAnnulmentNonIndv(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this non-individual annulment record!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.closest('form').submit();
        }
    });
}

function changePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page'); // Reset to first page when changing per_page
    window.location.href = url.toString();
}
</script>
@endsection
