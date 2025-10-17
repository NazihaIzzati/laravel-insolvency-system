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
                            <a href="{{ route('annulment-non-indv.download') }}" class="inline-flex items-center px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
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
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-white text-gray-700">
                                <i class="fas fa-building mr-1"></i>
                                Company Names
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-white text-gray-700">
                                <i class="fas fa-certificate mr-1"></i>
                                Registration Numbers
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-white text-gray-700">
                                <i class="fas fa-gavel mr-1"></i>
                                Court Cases
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-white text-gray-700">
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
        <div id="annulmentNonIndvLoadingSpinner" class="hidden bg-white p-8 mb-6 border-l-4 border-blue-500">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-accent-100 to-primary-100 rounded-full mb-4">
                    <i class="fas fa-spinner fa-spin text-neutral-800 text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 mb-2">Searching Records</h3>
                <p class="text-sm text-neutral-800 mb-4">Please wait while we search for matching non-individual annulment records...</p>
                <div class="w-full bg-white rounded-full h-2">
                    <div class="bg-gradient-to-r from-neutral-500 to-neutral-500 h-2 rounded-full animate-pulse" style="width: 60%"></div>
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
                            <h3 class="text-xl font-bold text-neutral-900">Search Results</h3>
                            <p class="text-sm text-neutral-800 mt-1">Matching non-individual annulment records found</p>
                        </div>
                    </div>
                    <button type="button" id="clearAnnulmentNonIndvSearchResultsBtn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-800 hover:text-gray-800 bg-white border border-neutral-300 rounded-lg hover:bg-white-50 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Clear Results
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto bg-white-50 px-8 py-6">
                <table class="w-full divide-y divide-gray-200" style="min-width: 1000px;">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-neutral-800 uppercase tracking-wider w-48">Company Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-neutral-800 uppercase tracking-wider w-32">Registration No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-neutral-800 uppercase tracking-wider w-32">Others</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-neutral-800 uppercase tracking-wider w-32">Court Case</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-neutral-800 uppercase tracking-wider w-24">Release Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-neutral-800 uppercase tracking-wider w-32">Release Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-neutral-800 uppercase tracking-wider w-32">Branch</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-neutral-800 uppercase tracking-wider w-24">Actions</th>
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
                <div class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-full mb-4">
                    <i class="fas fa-search text-gray-800 text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 mb-2">No Results Found</h3>
                <p class="text-sm text-neutral-800 mb-4">We couldn't find any records matching your search criteria.</p>
                <button id="clearAnnulmentNonIndvNoResultsBtn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-neutral-600 rounded hover:bg-neutral-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Try Different Search
                </button>
            </div>
        </div>

        <!-- Divider between search and main content -->
        <div class="border-t border-neutral-200 mb-8"></div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Records</h3>
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
                                <tr class="hover:bg-white transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="pill-badge pill-badge-company">{{ $annulment->company_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="pill-badge pill-badge-registration">{{ $annulment->company_registration_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-500">{{ $annulment->others ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-500">{{ $annulment->court_case_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-500">
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-500">{{ $annulment->formatted_updated_date }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-500">{{ $annulment->release_type ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-500">{{ $annulment->branch ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button onclick="showAnnulmentNonIndvDetails({{ $annulment->id }})" class="text-orange-600 hover:text-orange-900 transition-colors duration-200 px-2 py-1 rounded text-sm font-medium">View</button>
                                            <a href="{{ route('annulment-non-indv.edit', $annulment) }}" class="text-green-600 hover:text-green-900 transition-colors duration-200 px-2 py-1 rounded text-sm font-medium">Edit</a>
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
                        <div class="text-sm text-neutral-800">
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
                row.classList.add('bg-white-50');
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
                            <span class="pill-badge pill-badge-company">${result.company_name || 'N/A'}</span>
                            <div class="text-xs text-neutral-700 mt-1">Non-Individual Annulment</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="pill-badge pill-badge-registration">${result.company_registration_no || 'N/A'}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-900">${result.others || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-neutral-900 bg-purple-50 px-2 py-1 rounded inline-block">${result.court_case_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-900">
                        ${result.release_date ? 
                            `<span class="bg-green-50 text-green-800 px-2 py-1 rounded text-xs font-medium">${new Date(result.release_date).toLocaleDateString()}</span>` : 
                            '<span class="text-gray-800">N/A</span>'
                        }
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-900">
                        ${result.release_type ? 
                            `<span class="bg-neutral-50 text-neutral-800 px-2 py-1 rounded text-xs font-medium">${result.release_type}</span>` : 
                            '<span class="text-gray-800">N/A</span>'
                        }
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-900">${result.branch || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex flex-col space-y-1">
                        <a href="/annulment-non-indv/${result.id}" class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-blue-600 rounded hover:bg-blue-700 transition-colors duration-200 w-fit">
                            View
                        </a>
                        <a href="/annulment-non-indv/${result.id}/edit" class="inline-flex items-center px-2 py-1 text-xs font-bold text-white bg-green-600 rounded hover:bg-green-700 transition-colors duration-200 w-fit">
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

// Annulment Non-Individual Details Modal
function showAnnulmentNonIndvDetails(id) {
    fetch(`/annulment-non-indv/${id}`)
        .then(response => response.text())
        .then(html => {
            // Create a temporary div to parse the HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            // Extract the record details from the show page
            const recordDetails = tempDiv.querySelector('.pdf-content');
            if (recordDetails) {
                // Create modal content
                const modalContent = `
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900">Annulment Non-Individual Record Details</h3>
                                    <button onclick="closeAnnulmentNonIndvModal()" class="text-gray-400 hover:text-gray-600">
                                        <i class="bx bx-x text-2xl"></i>
                                    </button>
                                </div>
                                <div class="record-details">
                                    ${recordDetails.innerHTML}
                                </div>
                                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                                    <button onclick="closeAnnulmentNonIndvModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Add modal to body
                document.body.insertAdjacentHTML('beforeend', modalContent);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while fetching record details.',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK'
            });
        });
}

function closeAnnulmentNonIndvModal() {
    const modal = document.querySelector('.fixed.inset-0.bg-black.bg-opacity-50');
    if (modal) {
        modal.remove();
    }
}
</script>
@endsection
