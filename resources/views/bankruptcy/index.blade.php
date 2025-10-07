@extends('layouts.app')

@section('title', 'Individual Bankruptcy')

@section('content')
<div class="min-h-screen bg-primary-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary-900 to-accent-600 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-12">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-4xl font-light mb-3">Individual Bankruptcy</h1>
                        <p class="text-xl text-primary-100 mb-2">Manage individual bankruptcy records</p>
                        <p class="text-primary-200">Track and manage all individual bankruptcy cases</p>
                    </div>
                    <div class="text-right text-white">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-6 py-4">
                            <p class="text-sm text-primary-100 mb-1">Total Records</p>
                            <p class="text-lg font-medium">{{ $bankruptcies->count() }}</p>
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
                        <a href="{{ route('bankruptcy.create') }}" class="professional-button-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Record
                        </a>
                        <a href="{{ route('bankruptcy.bulk-upload') }}" class="professional-button-accent">
                            <i class="fas fa-upload mr-2"></i>
                            Bulk Upload
                        </a>
                        @if($bankruptcies->count() > 0)
                            <a href="{{ route('bankruptcy.download') }}" class="professional-button-success">
                                <i class="fas fa-download mr-2"></i>
                                Download Excel
                            </a>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard') }}" class="professional-button">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Records Table -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-primary-900">Bankruptcy Records</h3>
                <p class="text-sm text-primary-500 mt-1">All individual bankruptcy records</p>
            </div>
            <div class="professional-section-content">
                <!-- Search Form -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-search text-accent-600 mr-2"></i>
                        <h4 class="text-lg font-semibold text-gray-900">Quick Search</h4>
                    </div>
                    
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
                                       class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:border-accent-500 focus:ring-2 focus:ring-accent-200 focus:outline-none transition-colors duration-200 bg-white" 
                                       placeholder="IC number, insolvency number, or individual name"
                                       required>
                                <button type="button" id="clearSearchBtn" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1 rounded-full hover:bg-gray-100 cursor-pointer z-10" style="display: none;" title="Clear search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Search across individual names, IC numbers, and insolvency numbers
                            </p>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-accent-600 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 transition-colors duration-200 shadow-sm">
                                <i class="fas fa-search mr-2"></i>
                                Search Records
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Loading Spinner -->
                <div id="bankruptcyLoadingSpinner" class="hidden bg-white rounded-lg border border-gray-200 p-8 mb-6 shadow-sm">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-accent-100 rounded-full mb-4">
                            <i class="fas fa-spinner fa-spin text-accent-600 text-lg"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Searching Records</h3>
                        <p class="text-sm text-gray-500">Please wait while we search for matching records...</p>
                    </div>
                </div>
                
                <!-- Search Results -->
                <div id="bankruptcySearchResults" class="hidden bg-white rounded-lg border border-gray-200 mb-6 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Search Results</h3>
                                <p class="text-sm text-gray-500 mt-1">Matching records found</p>
                            </div>
                            <button type="button" id="clearBankruptcySearchResultsBtn" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Clear Results
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
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
                <div id="bankruptcyNoResults" class="hidden bg-white rounded-lg border border-gray-200 p-8 mb-6 shadow-sm">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-4">
                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Records Found</h3>
                        <p class="text-sm text-gray-500 mb-4">We couldn't find any records matching your search criteria.</p>
                        <div class="space-y-2 text-xs text-gray-400">
                            <p>• Try searching with different keywords</p>
                            <p>• Check for typos in names or IC numbers</p>
                            <p>• Use partial matches (e.g., "John" instead of "John Smith")</p>
                        </div>
                    </div>
                </div>
                <!-- Main Records Table -->
                <div id="mainRecordsTable">
                    @if($bankruptcies->count() > 0)
                        <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-primary-200" style="min-width: 1200px;">
                            <thead class="bg-primary-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-32">Insolvency No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-48">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-32">IC No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Others</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Court Case</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-24">RO Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-24">AO Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-32">Updated Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Branch</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-24">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-primary-200">
                            @foreach($bankruptcies as $bankruptcy)
                                    <tr class="hover:bg-primary-50 transition-colors duration-200">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm font-medium text-accent-600">{{ $bankruptcy->insolvency_no }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-primary-900">{{ $bankruptcy->name }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-primary-600">{{ $bankruptcy->ic_no }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-primary-900">{{ $bankruptcy->others ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-primary-900">{{ $bankruptcy->court_case_no ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-primary-900">
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
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-primary-900">
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
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-primary-900">{{ $bankruptcy->formatted_updated_date }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-primary-900">{{ $bankruptcy->branch ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('bankruptcy.show', $bankruptcy) }}" class="text-accent-600 hover:text-accent-700 transition-colors duration-200">View</a>
                                                <a href="{{ route('bankruptcy.edit', $bankruptcy) }}" class="text-green-600 hover:text-green-700 transition-colors duration-200">Edit</a>
                                                <form method="POST" action="{{ route('bankruptcy.destroy', $bankruptcy) }}" class="inline" onsubmit="return confirmDelete(event)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-700 transition-colors duration-200">Delete</button>
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
                    {{ $bankruptcies->links() }}
                </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-primary-900">No bankruptcy records</h3>
                        <p class="mt-1 text-sm text-primary-500">Get started by uploading new bankruptcy data.</p>
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
            alert('Please enter a search value.');
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
                alert('Search failed: ' + (data.message || 'Unknown error'));
                showMainTable();
            }
        })
        .catch(error => {
            bankruptcyLoadingSpinner.classList.add('hidden');
            showMainTable();
            console.error('Error:', error);
            alert('An error occurred while searching. Please try again.');
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
            row.className = 'hover:bg-gray-50 transition-colors duration-200';
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-accent-600 font-mono">${result.insolvency_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${result.name || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-600 font-mono">${result.ic_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-600">${result.court_case_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-600">${result.ro_date ? new Date(result.ro_date).toLocaleDateString() : 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-600">${result.ao_date ? new Date(result.ao_date).toLocaleDateString() : 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-3">
                        <a href="/bankruptcy/${result.id}" class="text-accent-600 hover:text-accent-700 transition-colors duration-200 font-medium">View</a>
                        <a href="/bankruptcy/${result.id}/edit" class="text-green-600 hover:text-green-700 transition-colors duration-200 font-medium">Edit</a>
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
</script>
@endsection
