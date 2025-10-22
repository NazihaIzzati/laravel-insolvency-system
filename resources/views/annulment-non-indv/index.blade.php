@extends('layouts.app')

@section('title', 'Non-Individual Annulment Records')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Actions Section -->
        <div class="professional-section mb-6">
            <div class="professional-section-content">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('annulment-non-indv.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Record
                        </a>
                        
                        <a href="{{ route('annulment-non-indv.bulk-upload') }}" class="inline-flex items-center px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            Bulk Upload
                        </a>
                        
                        @if($annulmentNonIndv->total() > 0)
                            <a href="{{ route('annulment-non-indv.download') }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>
                                Download Excel
                            </a>
                        @endif
                    </div>
                    <div class="flex gap-3 items-center">
                        <a href="{{ auth()->user()->isIdManagement() ? route('id-management.dashboard') : (auth()->user()->isSuperUser() ? route('dashboard') : (auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard'))) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Search Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-search text-orange-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Quick Search</h2>
                            <p class="text-sm text-gray-500">Find non-individual annulment records instantly</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center space-x-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle"></i>
                        <span>Search by company name, registration number, or court case number</span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <form id="annulmentNonIndvSearchForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="annulment_non_indv_search_input" class="block text-sm font-medium text-gray-700 mb-2">
                            Search Records
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="annulment_non_indv_search_input" 
                                   name="search_input" 
                                   class="block w-full pl-10 pr-12 py-3 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200" 
                                   placeholder="Enter company name, registration no, court case number, or other reference..."
                                   required>
                            <button type="button" 
                                    id="clearAnnulmentNonIndvSearchBtn" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200" 
                                    style="display: none;" 
                                    title="Clear search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <!-- Search Tags -->
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="pill-badge pill-badge-company">
                                <i class="fas fa-building mr-1"></i>
                                Company Names
                            </span>
                            <span class="pill-badge pill-badge-registration">
                                <i class="fas fa-certificate mr-1"></i>
                                Registration Numbers
                            </span>
                            <span class="pill-badge pill-badge-court">
                                <i class="fas fa-gavel mr-1"></i>
                                Court Cases
                            </span>
                            <span class="pill-badge pill-badge-reference">
                                <i class="fas fa-tag mr-1"></i>
                                References
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Search Records
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Loading Spinner -->
        <div id="annulmentNonIndvLoadingSpinner" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-12 mb-6">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4">
                    <i class="fas fa-spinner fa-spin text-orange-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Searching Records</h3>
                <p class="text-gray-500">Please wait while we search for matching non-individual annulment records...</p>
            </div>
        </div>
        
        <!-- Enhanced Search Results -->
        <div id="annulmentNonIndvSearchResults" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Search Results</h3>
                            <p class="text-sm text-gray-500">Matching non-individual annulment records found</p>
                        </div>
                    </div>
                    <button type="button" id="clearAnnulmentNonIndvSearchResultsBtn" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-white transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Clear Results
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" style="min-width: 1200px;">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Company Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Registration No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Others</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Court Case</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Release Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Updated Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Release Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Branch</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="annulmentNonIndvSearchResultsBody" class="bg-white divide-y divide-gray-200">
                        <!-- Results will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Enhanced No Results -->
        <div id="annulmentNonIndvNoResults" class="hidden bg-white p-16 mb-6">
            <div class="text-center max-w-2xl mx-auto">
                <!-- Animated Icon -->
                <div class="relative mb-8">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-red-100 to-pink-100 rounded-full mb-4 shadow-lg">
                        <svg class="w-12 h-12 text-red-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No Records Found</h3>
                <p class="text-gray-600 mb-6">We couldn't find any non-individual annulment records matching your search criteria.</p>
                <div class="space-y-3">
                    <p class="text-sm text-gray-500">Try adjusting your search terms:</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Check for typos in company names or registration numbers</li>
                        <li>• Try searching with partial information</li>
                        <li>• Use different keywords or references</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Records Table -->
        <div id="mainAnnulmentNonIndvRecordsTable" class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Non-Individual Annulment Records</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-700">Records</span>
                        <label for="per_page" class="text-sm font-medium text-gray-700">per page:</label>
                        <select id="per_page" name="per_page" class="text-sm border border-gray-300 rounded px-2 py-1" onchange="changePerPage(this.value)">
                            <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="p-6">

                <!-- Main Records Table -->
                <div id="mainAnnulmentNonIndvRecordsTable">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" style="min-width: 1200px;">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Company Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Registration No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Others</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Court Case</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Release Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Updated Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Release Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Branch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($annulmentNonIndv as $annulment)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $annulment->company_name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 font-mono">{{ $annulment->company_registration_no ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $annulment->others ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $annulment->court_case_no ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            @if($annulment->release_date)
                                                @if(is_string($annulment->release_date))
                                                    {{ \Carbon\Carbon::parse($annulment->release_date)->format('d/m/Y') }}
                                                @else
                                                    {{ $annulment->release_date->format('d/m/Y') }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $annulment->formatted_updated_date }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $annulment->release_type ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $annulment->branch ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('annulment-non-indv.show', $annulment) }}" class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>
                                            <a href="{{ route('annulment-non-indv.edit', $annulment) }}" class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-neutral-700">
                                        <div class="flex flex-col items-center">
                                            <svg class="mx-auto h-12 w-12 text-primary-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <p class="text-sm font-medium">No non-individual annulment records found</p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                <a href="{{ route('annulment-non-indv.create') }}" class="text-neutral-800 hover:text-neutral-700">Add the first record</a>
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
                        <div class="text-sm text-gray-700">
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
            row.className = 'hover:bg-gray-50 transition-colors duration-200';
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${result.company_name || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500 font-mono">${result.company_registration_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">${result.others || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">${result.court_case_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">
                        ${result.release_date ? 
                            new Date(result.release_date).toLocaleDateString() : 
                            'N/A'
                        }
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">
                        ${result.updated_at ? 
                            new Date(result.updated_at).toLocaleDateString() : 
                            'N/A'
                        }
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">${result.release_type || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">${result.branch || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-2">
                        <a href="/annulment-non-indv/${result.id}" class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                        <a href="/annulment-non-indv/${result.id}/edit" class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
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

// Note: Modal functions removed as we now use direct links to show pages
</script>
@endsection
