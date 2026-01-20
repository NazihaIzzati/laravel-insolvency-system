@extends('layouts.app')

@section('title', 'Annulment Records')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Actions Section -->
        <div class="professional-section mb-6">
            <div class="professional-section-content">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('annulment-indv.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Record
                        </a>
                        
                        <a href="{{ route('annulment-indv.bulk-upload') }}" class="inline-flex items-center px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            Bulk Upload
                        </a>
                        
                        @if($annulmentIndv->total() > 0)
                            <a href="{{ route('annulment-indv.download') }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
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
                            <p class="text-sm text-gray-500">Find annulment records instantly</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center space-x-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle"></i>
                        <span>Search by IC number, name, or court case number</span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <form id="annulmentSearchForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="annulment_search_input" class="block text-sm font-medium text-gray-700 mb-2">
                            Search Records
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="annulment_search_input" 
                                   name="search_input" 
                                   class="block w-full pl-10 pr-12 py-3 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200" 
                                   placeholder="Enter IC number, name, court case number, or other reference..."
                                   required>
                            <button type="button" 
                                    id="clearAnnulmentSearchBtn" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200" 
                                    style="display: none;" 
                                    title="Clear search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <!-- Search Tags -->
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="pill-badge pill-badge-ic">
                                <i class="fas fa-id-card mr-1"></i>
                                IC Numbers
                            </span>
                            <span class="pill-badge pill-badge-name">
                                <i class="fas fa-user mr-1"></i>
                                Names
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
        <div id="annulmentLoadingSpinner" class="hidden bg-white p-12 mb-6">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-neutral-100 to-neutral-200 rounded-full mb-6">
                    <i class="fas fa-spinner fa-spin text-neutral-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Searching Records</h3>
                <p class="text-gray-600 mb-4">Please wait while we search for matching annulment records...</p>
                <div class="w-full bg-white rounded-full h-2">
                    <div class="bg-gradient-to-r from-neutral-500 to-neutral-600 h-2 rounded-full animate-pulse" style="width: 60%"></div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Search Results -->
        <div id="annulmentSearchResults" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Search Results</h3>
                            <p class="text-sm text-gray-500">Matching annulment records found</p>
                        </div>
                    </div>
                    <button type="button" id="clearAnnulmentSearchResultsBtn" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-white transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Clear Results
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" style="min-width: 1200px;">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">IC No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Others</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Court Case</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Release Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Updated Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Release Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Branch</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="annulmentSearchResultsBody" class="bg-white divide-y divide-gray-200">
                        <!-- Results will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Enhanced No Results -->
        <div id="annulmentNoResults" class="hidden bg-white p-16 mb-6">
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
        <div id="mainAnnulmentRecordsTable" class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Individual Annulment Records</h3>
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
                <div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" style="min-width: 1200px;">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">IC No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Others</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Court Case</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Release Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Updated Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Release Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Branch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($annulmentIndv as $annulment)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $annulment->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 font-mono">{{ $annulment->ic_no ?? 'N/A' }}</div>
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
                                            <button onclick="showAnnulmentDetails({{ $annulment->id }})" class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </button>
                                            <a href="{{ route('annulment-indv.edit', $annulment) }}" class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition-colors duration-200">
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
                                    <td colspan="9" class="px-4 py-8 text-center text-neutral-500">
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
                        <div class="text-sm text-gray-700">
                            Showing {{ $annulmentIndv->firstItem() }} to {{ $annulmentIndv->lastItem() }} of {{ $annulmentIndv->total() }} results
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $annulmentIndv->links() }}
                        </div>
                    </div>
                @endif
                </div>
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
            mainAnnulmentRecordsTable.classList.remove('hidden');
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
        
        // Hide main records table
        mainAnnulmentRecordsTable.classList.add('hidden');
        
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
            row.className = 'hover:bg-gray-50 transition-colors duration-200';
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${result.name || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500 font-mono">${result.ic_no || 'N/A'}</div>
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
                        <a href="/annulment-indv/${result.id}" class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                        <a href="/annulment-indv/${result.id}/edit" class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
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
        annulmentSearchResults.classList.add('hidden');
        mainAnnulmentRecordsTable.classList.add('hidden');
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

// Annulment Details Modal
function showAnnulmentDetails(id) {
    fetch(`/annulment-indv/${id}`)
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
                                    <h3 class="text-xl font-semibold text-gray-900">Annulment Record Details</h3>
                                    <button onclick="closeAnnulmentModal()" class="text-gray-400 hover:text-gray-600">
                                        <i class="bx bx-x text-2xl"></i>
                                    </button>
                                </div>
                                <div class="record-details">
                                    ${recordDetails.innerHTML}
                                </div>
                                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                                    <button onclick="closeAnnulmentModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
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

function closeAnnulmentModal() {
    const modal = document.querySelector('.fixed.inset-0.bg-black.bg-opacity-50');
    if (modal) {
        modal.remove();
    }
}

// Download Filtered Data functionality
document.addEventListener('DOMContentLoaded', function() {
    const downloadFilteredBtn = document.getElementById('downloadFilteredBtn');
    const searchInput = document.getElementById('annulment_search_input');
    const searchForm = document.getElementById('annulmentSearchForm');
    
    // Enable/disable download filtered button based on search input
    if (searchInput && downloadFilteredBtn) {
        searchInput.addEventListener('input', function() {
            if (this.value.trim().length > 0) {
                downloadFilteredBtn.disabled = false;
                downloadFilteredBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                downloadFilteredBtn.classList.add('hover:bg-orange-600');
            } else {
                downloadFilteredBtn.disabled = true;
                downloadFilteredBtn.classList.add('opacity-50', 'cursor-not-allowed');
                downloadFilteredBtn.classList.remove('hover:bg-orange-600');
            }
        });
        
        // Handle download filtered button click
        downloadFilteredBtn.addEventListener('click', function() {
            const searchValue = searchInput.value.trim();
            
            if (searchValue.length === 0) {
                Swal.fire({
                    title: 'No Search Term',
                    text: 'Please enter a search term to download filtered records.',
                    icon: 'warning',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Show confirmation dialog
            Swal.fire({
                title: 'Download Filtered Data',
                text: `Download records matching "${searchValue}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Download',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("annulment-indv.download-filtered") }}';
                    
                    // Add CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (csrfToken) {
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken.getAttribute('content');
                        form.appendChild(csrfInput);
                    }
                    
                    // Add search input
                    const searchInputField = document.createElement('input');
                    searchInputField.type = 'hidden';
                    searchInputField.name = 'search_input';
                    searchInputField.value = searchValue;
                    form.appendChild(searchInputField);
                    
                    // Submit form
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                }
            });
        });
    }
});
</script>
@endsection
