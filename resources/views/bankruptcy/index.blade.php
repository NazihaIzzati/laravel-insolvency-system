@extends('layouts.app')

@section('title', 'Individual Bankruptcy')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Actions Section -->
        <div class="professional-section mb-6">
            <div class="professional-section-content">
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('bankruptcy.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Record
                        </a>
                        
                        <a href="{{ route('bankruptcy.bulk-upload') }}" class="inline-flex items-center px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            Bulk Upload
                        </a>
                        
                        @if($bankruptcies->count() > 0)
                            <a href="{{ route('bankruptcy.download') }}" class="inline-flex items-center px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
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
                            <p class="text-sm text-gray-500">Find bankruptcy records instantly</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center space-x-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle"></i>
                        <span>Search by IC number, insolvency number, or name</span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <form id="bankruptcySearchForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="bankruptcy_search_input" class="block text-sm font-medium text-gray-700 mb-2">
                            Search Records
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="bankruptcy_search_input" 
                                   name="search_input" 
                                   class="block w-full pl-10 pr-12 py-3 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200" 
                                   placeholder="Enter IC number, insolvency number, or individual name..."
                                   required>
                            <button type="button" 
                                    id="clearSearchBtn" 
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
                            <span class="pill-badge pill-badge-insolvency">
                                <i class="fas fa-file-invoice mr-1"></i>
                                Insolvency Numbers
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-white text-gray-700">
                                <i class="fas fa-gavel mr-1"></i>
                                Court Cases
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

        <!-- Records Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Bankruptcy Records</h3>
                        @if($bankruptcies->count() > 0)
                            <p class="text-sm text-gray-500 mt-1">
                                Showing {{ $bankruptcies->firstItem() }} to {{ $bankruptcies->lastItem() }} of {{ $bankruptcies->total() }} results
                            </p>
                        @endif
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

                <!-- Loading Spinner -->
                <div id="bankruptcyLoadingSpinner" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-12 mb-6">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4">
                            <i class="fas fa-spinner fa-spin text-orange-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Searching Records</h3>
                        <p class="text-gray-500">Please wait while we search for matching records...</p>
                    </div>
                </div>
                
                <!-- Search Results -->
                <div id="bankruptcySearchResults" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-check-circle text-orange-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Search Results</h3>
                                    <p class="text-sm text-gray-500">Matching records found</p>
                                </div>
                            </div>
                            <button type="button" id="clearBankruptcySearchResultsBtn" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-white transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Clear Results
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Insolvency No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Court Case No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RO Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AO Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="bankruptcySearchResultsBody" class="bg-white divide-y divide-gray-200">
                                <!-- Results will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- No Results -->
                <div id="bankruptcyNoResults" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-12 mb-6">
                    <div class="text-center max-w-2xl mx-auto">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Records Found</h3>
                        <p class="text-gray-500 mb-6">We couldn't find any records matching your search criteria.</p>
                        
                        <div class="bg-white rounded-lg p-6">
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Try searching with:</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-600">
                                <div>• Different keywords</div>
                                <div>• Partial matches</div>
                                <div>• Check for typos</div>
                                <div>• Broader search terms</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main Records Table -->
                <div id="mainRecordsTable">
                    @if($bankruptcies->count() > 0)
                        <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" style="min-width: 1200px;">
                            <thead class="bg-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Insolvency No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">IC No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Others</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Court Case</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">RO Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">AO Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Updated Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Branch</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bankruptcies as $bankruptcy)
                                    <tr class="hover:bg-white transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $bankruptcy->insolvency_no }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $bankruptcy->name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500">{{ $bankruptcy->ic_no }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500">{{ $bankruptcy->others ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500">{{ $bankruptcy->court_case_no ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500">
                                                @if($bankruptcy->ro_date)
                                                    @if(is_string($bankruptcy->ro_date))
                                                        {{ \Carbon\Carbon::parse($bankruptcy->ro_date)->format('d/m/Y') }}
                                                    @else
                                                        {{ $bankruptcy->ro_date->format('d/m/Y') }}
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500">
                                                @if($bankruptcy->ao_date)
                                                    @if(is_string($bankruptcy->ao_date))
                                                        {{ \Carbon\Carbon::parse($bankruptcy->ao_date)->format('d/m/Y') }}
                                                    @else
                                                        {{ $bankruptcy->ao_date->format('d/m/Y') }}
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500">{{ $bankruptcy->formatted_updated_date }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-500">{{ $bankruptcy->branch ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button onclick="showBankruptcyDetails({{ $bankruptcy->id }})" class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    View
                                                </button>
                                                <a href="{{ route('bankruptcy.edit', $bankruptcy) }}" class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $bankruptcies->links() }}
                </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-neutral-900">No bankruptcy records</h3>
                        <p class="mt-1 text-sm text-neutral-700">Get started by uploading new bankruptcy data.</p>
                        <div class="mt-6">
                            <a href="{{ route('bankruptcy.create') }}" class="professional-button-primary">
                                <i class="fas fa-plus mr-2"></i>
                                Add New Record
                            </a>
                        </div>
                    </div>
                @endif
                </div> <!-- End of mainRecordsTable -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bankruptcySearchForm = document.getElementById('bankruptcySearchForm');
    const bankruptcySearchResults = document.getElementById('bankruptcySearchResults');
    const bankruptcySearchResultsBody = document.getElementById('bankruptcySearchResultsBody');
    const bankruptcyNoResults = document.getElementById('bankruptcyNoResults');
    const bankruptcyLoadingSpinner = document.getElementById('bankruptcyLoadingSpinner');
    const mainRecordsTable = document.getElementById('mainRecordsTable');
    const searchInput = document.getElementById('bankruptcy_search_input');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const clearBankruptcySearchResultsBtn = document.getElementById('clearBankruptcySearchResultsBtn');

    // Debug: Check if elements exist
    console.log('Elements found:', {
        bankruptcySearchForm: !!bankruptcySearchForm,
        searchInput: !!searchInput,
        clearSearchBtn: !!clearSearchBtn,
        mainRecordsTable: !!mainRecordsTable
    });

    // Check if required elements exist
    if (!searchInput || !clearSearchBtn || !mainRecordsTable) {
        console.error('Required elements not found');
        return;
    }

    // Test function to manually trigger clear (for debugging)
    window.testClearButton = function() {
        console.log('Testing clear button manually');
        if (clearSearchBtn) {
            clearSearchBtn.click();
        }
    };

    // Handle form submission
    bankruptcySearchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const searchValue = formData.get('search_input');
        
        if (!searchValue) {
            Swal.fire({
                title: 'Search Required',
                text: 'Please enter a search value.',
                icon: 'warning',
                confirmButtonColor: '#ea580c',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Hide all previous results and show loading
        bankruptcyLoadingSpinner.classList.remove('hidden');
        bankruptcySearchResults.classList.add('hidden');
        bankruptcyNoResults.classList.add('hidden');
        mainRecordsTable.classList.add('hidden');
        
        fetch('{{ route("bankruptcy.search") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            bankruptcyLoadingSpinner.classList.add('hidden');
            
            if (data.success) {
                if (data.results && data.results.length > 0) {
                    displayBankruptcyResults(data.results);
                } else {
                    showBankruptcyNoResults();
                }
            } else {
                Swal.fire({
                    title: 'Search Failed',
                    text: data.message || 'Unknown error occurred',
                    icon: 'error',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'OK'
                });
                showMainTable();
            }
        })
        .catch(error => {
            bankruptcyLoadingSpinner.classList.add('hidden');
            showMainTable();
            console.error('Error:', error);
            Swal.fire({
                title: 'Search Error',
                text: 'An error occurred while searching. Please try again.',
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        });
    });

    function displayBankruptcyResults(results) {
        // Clear previous results
        bankruptcySearchResultsBody.innerHTML = '';
        bankruptcyNoResults.classList.add('hidden');
        
        // Update results header with count
        const resultsCount = results.length;
        const resultsHeader = bankruptcySearchResults.querySelector('h3');
        const resultsSubtext = bankruptcySearchResults.querySelector('p');
        
        if (resultsCount === 1) {
            resultsHeader.textContent = 'Search Results';
            resultsSubtext.textContent = '1 matching record found';
        } else {
            resultsHeader.textContent = 'Search Results';
            resultsSubtext.textContent = `${resultsCount} matching records found`;
        }
        
        results.forEach(result => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-white-50 transition-colors duration-200';
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-neutral-800 font-mono">${result.insolvency_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-neutral-900">${result.name || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-800 font-mono">${result.ic_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-800">${result.court_case_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-800">${result.ro_date ? new Date(result.ro_date).toLocaleDateString() : 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-800">${result.ao_date ? new Date(result.ao_date).toLocaleDateString() : 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-2">
                        <a href="/bankruptcy/${result.id}" class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                        <a href="/bankruptcy/${result.id}/edit" class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                    </div>
                </td>
            `;
            bankruptcySearchResultsBody.appendChild(row);
        });
        
        bankruptcySearchResults.classList.remove('hidden');
    }

    function showBankruptcyNoResults() {
        bankruptcySearchResults.classList.add('hidden');
        bankruptcyNoResults.classList.remove('hidden');
    }

    function showMainTable() {
        bankruptcySearchResults.classList.add('hidden');
        bankruptcyNoResults.classList.add('hidden');
        mainRecordsTable.classList.remove('hidden');
    }

    function clearSearch() {
        console.log('Clear search function called'); // Debug log
        try {
            searchInput.value = '';
            showMainTable();
            clearSearchBtn.style.display = 'none';
            console.log('Clear search completed successfully');
        } catch (error) {
            console.error('Error in clearSearch:', error);
        }
    }

    // Clear button functionality
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Clear button clicked'); // Debug log
            clearSearch();
        });
        console.log('Clear button event listener added');
    } else {
        console.error('Clear button not found');
    }

    // Clear search results button functionality
    if (clearBankruptcySearchResultsBtn) {
        clearBankruptcySearchResultsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Clear search results button clicked');
            clearSearch();
        });
        console.log('Clear search results button event listener added');
    } else {
        console.error('Clear search results button not found');
    }

    // Show/hide clear button based on input
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            console.log('Input changed:', this.value); // Debug log
            if (this.value.trim() !== '') {
                clearSearchBtn.style.display = 'block';
                console.log('Clear button shown');
            } else {
                clearSearchBtn.style.display = 'none';
                console.log('Clear button hidden');
            }
        });
        console.log('Input event listener added');
    } else {
        console.error('Search input not found');
    }
});

function changePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page'); // Reset to first page when changing per_page
    window.location.href = url.toString();
}

function confirmDelete(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
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

// Bankruptcy Details Modal
function showBankruptcyDetails(id) {
    fetch(`/bankruptcy/${id}`)
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
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="bankruptcyModal">
                        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900">Bankruptcy Record Details</h3>
                                </div>
                                <div class="record-details">
                                    ${recordDetails.innerHTML.replace(/onclick="history\.back\(\)"/g, 'onclick="closeBankruptcyModal()"')}
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

function closeBankruptcyModal() {
    const modal = document.getElementById('bankruptcyModal');
    if (modal) {
        modal.remove();
    }
}

</script>
@endsection
