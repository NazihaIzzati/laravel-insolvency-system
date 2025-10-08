@extends('layouts.app')

@section('title', 'Annulment Records')

@section('content')
<div class="min-h-screen bg-neutral-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-neutral-700 to-neutral-800 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-12">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-4xl font-light mb-3">Annulment Records</h1>
                        <p class="text-xl text-neutral-100 mb-2">Manage annulment individual profiles</p>
                        <p class="text-neutral-200">Track and manage all annulment cases</p>
                    </div>
                    <div class="text-right text-white">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-6 py-4">
                            <p class="text-sm text-neutral-100 mb-1">Total Records</p>
                            <p class="text-lg font-medium">{{ $annulmentIndv->total() }}</p>
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
                        <a href="{{ route('annulment-indv.create') }}" class="professional-button-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Record
                        </a>
                        <a href="{{ route('annulment-indv.bulk-upload') }}" class="professional-button-accent">
                            <i class="fas fa-upload mr-2"></i>
                            Bulk Upload
                        </a>
                        @if($annulmentIndv->total() > 0)
                            <a href="{{ route('annulment-indv.download') }}" class="professional-button-success">
                                <i class="fas fa-download mr-2"></i>
                                Download Excel
                            </a>
                        @endif
                    </div>
                    <div class="flex gap-3 items-center">
                        <div class="flex items-center gap-2">
                            <label for="per_page" class="text-sm font-medium text-neutral-700">Records per page:</label>
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

        <!-- Quick Search Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-neutral-200 mb-8 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-neutral-50 to-neutral-100 px-8 py-6 border-b border-neutral-200">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl mr-4 shadow-lg">
                        <i class="fas fa-search text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-neutral-900">Quick Search</h4>
                        <p class="text-sm text-neutral-600 mt-1">Find annulment records instantly with advanced search capabilities</p>
                    </div>
                </div>
            </div>
            
            <!-- Card Body -->
            <div class="p-8">
                <form id="annulmentSearchForm" class="space-y-6">
                    @csrf
                    <div>
                        <label for="annulment_search_input" class="block text-sm font-semibold text-neutral-700 mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Search Records
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-neutral-400 text-lg"></i>
                            </div>
                            <input type="text" 
                                   id="annulment_search_input" 
                                   name="search_input" 
                                   class="block w-full pl-12 pr-16 py-4 border-2 border-neutral-200 rounded-xl text-base placeholder-neutral-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 bg-white shadow-sm hover:shadow-md" 
                                   placeholder="Enter IC number, name, court case number, or other reference..."
                                   required>
                            <button type="button" id="clearAnnulmentSearchBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-neutral-400 hover:text-neutral-600 transition-all duration-200 p-2 rounded-full hover:bg-neutral-100 cursor-pointer z-10" style="display: none;" title="Clear search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <!-- Search Capabilities -->
                        <div class="mt-4">
                            <p class="text-xs font-medium text-neutral-500 mb-3">Search capabilities:</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    <i class="fas fa-id-card mr-2"></i>
                                    IC Numbers
                                </span>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    <i class="fas fa-user mr-2"></i>
                                    Names
                                </span>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                    <i class="fas fa-gavel mr-2"></i>
                                    Court Cases
                                </span>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-orange-50 text-orange-700 border border-orange-200">
                                    <i class="fas fa-tag mr-2"></i>
                                    References
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-search mr-2"></i>
                            Search Records
                        </button>
                        
                        <div class="flex items-center space-x-4">
                            <button type="button" id="clearAnnulmentSearchForm" class="inline-flex items-center px-4 py-2 text-neutral-600 hover:text-neutral-800 font-medium transition-colors duration-200 hover:bg-neutral-100 rounded-lg">
                                <i class="fas fa-eraser mr-2"></i>
                                Clear Form
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Loading Spinner -->
        <div id="annulmentLoadingSpinner" class="hidden bg-gray-50 p-12 mb-6">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-neutral-100 to-neutral-200 rounded-full mb-6">
                    <i class="fas fa-spinner fa-spin text-neutral-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Searching Records</h3>
                <p class="text-gray-600 mb-4">Please wait while we search for matching annulment records...</p>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-neutral-500 to-neutral-600 h-2 rounded-full animate-pulse" style="width: 60%"></div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Search Results -->
        <div id="annulmentSearchResults" class="hidden bg-white mb-6">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-8 py-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mr-4">
                            <i class="fas fa-check-circle text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Search Results</h3>
                            <p class="text-sm text-gray-600 mt-1">Matching annulment records found</p>
                        </div>
                    </div>
                    <button type="button" id="clearAnnulmentSearchResultsBtn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Clear Results
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto bg-gray-50 px-8 py-6">
                <table class="w-full divide-y divide-gray-200" style="min-width: 1000px;">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-48">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">IC No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Others</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Court Case</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-24">Release Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Release Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-32">Branch</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="annulmentSearchResultsBody" class="bg-white divide-y divide-gray-200">
                        <!-- Results will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Enhanced No Results -->
        <div id="annulmentNoResults" class="hidden bg-gray-50 p-16 mb-6">
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
                <p class="text-gray-600 mb-6">We couldn't find any annulment records matching your search criteria.</p>
                <div class="space-y-3">
                    <p class="text-sm text-gray-500">Try adjusting your search terms:</p>
                    <ul class="text-sm text-gray-500 space-y-1">
                        <li>• Check for typos in IC numbers or names</li>
                        <li>• Try searching with partial information</li>
                        <li>• Use different keywords or references</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Records Table -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-neutral-900">Annulment Records</h3>
                <p class="text-sm text-neutral-500 mt-1">All annulment individual profiles</p>
            </div>
            <div class="professional-section-content">
                <!-- Main Records Table -->
                <div id="mainAnnulmentRecordsTable">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200" style="min-width: 1200px;">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-48">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-32">IC No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-40">Others</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-40">Court Case</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-24">Release Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-32">Updated Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-40">Release Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-40">Branch</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-neutral-200">
                            @forelse($annulmentIndv as $annulment)
                                <tr class="hover:bg-neutral-50 transition-colors duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-neutral-900">{{ $annulment->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-neutral-600">{{ $annulment->ic_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-neutral-900">{{ $annulment->others ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-neutral-900">{{ $annulment->court_case_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-neutral-900">
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
                                        <span class="text-sm text-neutral-900">{{ $annulment->formatted_updated_date }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-neutral-900">{{ $annulment->release_type ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-neutral-900">{{ $annulment->branch ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('annulment-indv.show', $annulment) }}" class="text-accent-600 hover:text-accent-700 transition-colors duration-200">View</a>
                                            <a href="{{ route('annulment-indv.edit', $annulment) }}" class="text-green-600 hover:text-green-700 transition-colors duration-200">Edit</a>
                                            <form method="POST" action="{{ route('annulment-indv.destroy', $annulment) }}" class="inline" onsubmit="return confirmDeleteAnnulment(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700 transition-colors duration-200">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-neutral-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="mx-auto h-12 w-12 text-neutral-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="text-sm font-medium">No annulment records found</p>
                                            <p class="text-xs text-neutral-400 mt-1">
                                                <a href="{{ route('annulment-indv.create') }}" class="text-neutral-600 hover:text-neutral-700">Add the first record</a>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($annulmentIndv->hasPages())
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-neutral-600">
                            Showing {{ $annulmentIndv->firstItem() }} to {{ $annulmentIndv->lastItem() }} of {{ $annulmentIndv->total() }} results
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $annulmentIndv->links() }}
                        </div>
                    </div>
                @endif
                </div> <!-- End mainAnnulmentRecordsTable -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const annulmentSearchForm = document.getElementById('annulmentSearchForm');
    const annulmentSearchInput = document.getElementById('annulment_search_input');
    const clearAnnulmentSearchBtn = document.getElementById('clearAnnulmentSearchBtn');
    const annulmentLoadingSpinner = document.getElementById('annulmentLoadingSpinner');
    const annulmentSearchResults = document.getElementById('annulmentSearchResults');
    const annulmentSearchResultsBody = document.getElementById('annulmentSearchResultsBody');
    const annulmentNoResults = document.getElementById('annulmentNoResults');
    const clearAnnulmentSearchResultsBtn = document.getElementById('clearAnnulmentSearchResultsBtn');
    const mainAnnulmentRecordsTable = document.getElementById('mainAnnulmentRecordsTable');

    // Handle form submission
    annulmentSearchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const searchValue = annulmentSearchInput.value.trim();
        
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
        annulmentLoadingSpinner.classList.remove('hidden');
        annulmentSearchResults.classList.add('hidden');
        annulmentNoResults.classList.add('hidden');
        mainAnnulmentRecordsTable.classList.add('hidden');

        // Make AJAX request
        fetch('{{ route("annulment-indv.search") }}', {
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
            annulmentLoadingSpinner.classList.add('hidden');
            
            if (data.success && data.results.length > 0) {
                displayAnnulmentSearchResults(data.results);
            } else {
                showAnnulmentNoResults();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            annulmentLoadingSpinner.classList.add('hidden');
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
    clearAnnulmentSearchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        clearAnnulmentSearch();
    });

    // Handle clear search results button
    clearAnnulmentSearchResultsBtn.addEventListener('click', function(e) {
        e.preventDefault();
        clearAnnulmentSearch();
    });

    // Handle clear search from no results button
    const clearAnnulmentSearchFromNoResults = document.getElementById('clearAnnulmentSearchFromNoResults');
    if (clearAnnulmentSearchFromNoResults) {
        clearAnnulmentSearchFromNoResults.addEventListener('click', function(e) {
            e.preventDefault();
            clearAnnulmentSearch();
        });
    }

    // Handle input changes to show/hide clear button
    annulmentSearchInput.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            clearAnnulmentSearchBtn.style.display = 'block';
        } else {
            clearAnnulmentSearchBtn.style.display = 'none';
        }
    });

    function clearAnnulmentSearch() {
        annulmentSearchInput.value = '';
        clearAnnulmentSearchBtn.style.display = 'none';
        annulmentSearchResults.classList.add('hidden');
        annulmentNoResults.classList.add('hidden');
        mainAnnulmentRecordsTable.classList.remove('hidden');
    }

    function displayAnnulmentSearchResults(results) {
        annulmentSearchResultsBody.innerHTML = '';
        
        // Update results count in header
        const resultsCount = results.length;
        const resultsHeader = annulmentSearchResults.querySelector('h3');
        const resultsSubtext = annulmentSearchResults.querySelector('p');
        
        if (resultsCount === 1) {
            resultsHeader.textContent = 'Search Results';
            resultsSubtext.textContent = '1 matching annulment record found';
        } else {
            resultsHeader.textContent = 'Search Results';
            resultsSubtext.textContent = `${resultsCount} matching annulment records found`;
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
                <td class="px-8 py-6 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                <span class="text-sm font-bold text-white">${(result.name || 'N/A').charAt(0).toUpperCase()}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-bold text-gray-900">${result.name || 'N/A'}</div>
                            <div class="text-xs text-gray-500">Annulment Record</div>
                        </div>
                    </div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 bg-blue-50 px-3 py-1 rounded-lg inline-block">${result.ic_no || 'N/A'}</div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${result.others || 'N/A'}</div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 bg-purple-50 px-3 py-1 rounded-lg inline-block">${result.court_case_no || 'N/A'}</div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        ${result.release_date ? 
                            `<span class="bg-green-50 text-green-800 px-3 py-1 rounded-lg text-xs font-medium">${new Date(result.release_date).toLocaleDateString()}</span>` : 
                            '<span class="text-gray-400">N/A</span>'
                        }
                    </div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        ${result.release_type ? 
                            `<span class="bg-orange-50 text-orange-800 px-3 py-1 rounded-lg text-xs font-medium">${result.release_type}</span>` : 
                            '<span class="text-gray-400">N/A</span>'
                        }
                    </div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${result.branch || 'N/A'}</div>
                </td>
                <td class="px-8 py-6 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-3">
                        <a href="/annulment-indv/${result.id}" class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-eye mr-2"></i>
                            View
                        </a>
                        <a href="/annulment-indv/${result.id}/edit" class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>
                    </div>
                </td>
            `;
            
            annulmentSearchResultsBody.appendChild(row);
        });
        
        annulmentSearchResults.classList.remove('hidden');
    }

    function showAnnulmentNoResults() {
        annulmentNoResults.classList.remove('hidden');
    }
});

function confirmDeleteAnnulment(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this annulment record!",
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
