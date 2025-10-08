@extends('layouts.app')

@section('title', 'Non-Individual Bankruptcy')

@section('content')
<div class="min-h-screen bg-neutral-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-neutral-900 to-accent-600 rounded-xl shadow-lg mb-8">
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
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('non-individual-bankruptcy.create') }}" class="professional-button-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Record
                        </a>
                        <a href="{{ route('non-individual-bankruptcy.bulk-upload') }}" class="professional-button-accent">
                            <i class="fas fa-upload mr-2"></i>
                            Bulk Upload
                        </a>
                        @if($nonIndividualBankruptcies->count() > 0)
                            <a href="{{ route('non-individual-bankruptcy.download') }}" class="professional-button-success">
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
                <h3 class="text-lg font-medium text-neutral-900">Non-Individual Bankruptcy Records</h3>
                <p class="text-sm text-neutral-700 mt-1">All company and organization bankruptcy records</p>
            </div>
            <div class="professional-section-content">
                <!-- Search Form -->
                <div class="bg-white rounded-lg border border-neutral-200 p-6 mb-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-search text-neutral-800 mr-2"></i>
                        <h4 class="text-lg font-semibold text-neutral-900">Quick Search</h4>
                    </div>
                    
                    <form id="nonIndividualBankruptcySearchForm" class="space-y-4">
                        @csrf
                        <div>
                            <label for="non_individual_bankruptcy_search_input" class="block text-sm font-medium text-neutral-700 mb-2">
                                Search Records
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-800"></i>
                                </div>
                                <input type="text" 
                                       id="non_individual_bankruptcy_search_input" 
                                       name="search_input" 
                                       class="block w-full pl-10 pr-12 py-3 border border-neutral-300 rounded-lg text-sm placeholder-gray-500 focus:border-neutral-500 focus:ring-2 focus:ring-neutral-200 focus:outline-none transition-colors duration-200 bg-white" 
                                       placeholder="Company name, registration number, insolvency number, or court case number"
                                       required>
                                <button type="button" id="clearNonIndividualSearchBtn" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-800 hover:text-neutral-800 transition-colors duration-200 p-1 rounded-full hover:bg-gray-100 cursor-pointer z-10" style="display: none;" title="Clear search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-neutral-700">
                                Search across company names, registration numbers, insolvency numbers, and court case numbers
                            </p>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-neutral-600 hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 transition-colors duration-200 shadow-sm">
                                <i class="fas fa-search mr-2"></i>
                                Search Records
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Loading Spinner -->
                <div id="nonIndividualBankruptcyLoadingSpinner" class="hidden bg-white rounded-lg border border-neutral-200 p-8 mb-6 shadow-sm">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-accent-100 rounded-full mb-4">
                            <i class="fas fa-spinner fa-spin text-neutral-800 text-lg"></i>
                        </div>
                        <h3 class="text-lg font-medium text-neutral-900 mb-2">Searching Records</h3>
                        <p class="text-sm text-neutral-700">Please wait while we search for matching records...</p>
                    </div>
                </div>

                <!-- Search Results -->
                <div id="nonIndividualBankruptcySearchResults" class="hidden bg-white rounded-lg border border-neutral-200 mb-6 shadow-sm">
                    <div class="px-6 py-4 border-b border-neutral-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-neutral-900">Search Results</h3>
                                <p class="text-sm text-neutral-700 mt-1">Matching records found</p>
                            </div>
                            <button type="button" id="clearSearchResultsBtn" class="text-sm text-neutral-700 hover:text-neutral-700 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Clear Results
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-white-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Insolvency No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Company Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Registration No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Court Case No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Winding Up Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Updated Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="nonIndividualBankruptcySearchResultsBody" class="bg-white divide-y divide-gray-200">
                                <!-- Search results will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- No Results Message -->
                <div id="nonIndividualBankruptcyNoResults" class="hidden bg-white rounded-lg border border-neutral-200 p-8 mb-6 shadow-sm">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-4">
                            <svg class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-neutral-900 mb-2">No Records Found</h3>
                        <p class="text-sm text-neutral-700 mb-4">We couldn't find any records matching your search criteria.</p>
                        <div class="space-y-2 text-xs text-gray-800">
                            <p>• Try searching with different keywords</p>
                            <p>• Check for typos in company names or numbers</p>
                            <p>• Use partial matches (e.g., "ABC" instead of "ABC Company Sdn Bhd")</p>
                        </div>
                    </div>
                </div>

                <!-- Main Records Table -->
                <div id="mainNonIndividualRecordsTable">
            @if($nonIndividualBankruptcies->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Insolvency No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Company Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Company Registration No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Others</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Court Case No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Date of Winding Up/Resolution</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Updated Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Branch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($nonIndividualBankruptcies as $nonIndividualBankruptcy)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-neutral-900">
                                        {{ $nonIndividualBankruptcy->insolvency_no }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                        {{ $nonIndividualBankruptcy->company_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-neutral-900">
                                        {{ $nonIndividualBankruptcy->company_registration_no }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                        {{ $nonIndividualBankruptcy->others ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                        {{ $nonIndividualBankruptcy->court_case_no ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                                        {{ $nonIndividualBankruptcy->formatted_updated_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
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
                                                  class="inline" onsubmit="return confirmDeactivate(event)">
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
                        <svg class="mx-auto h-12 w-12 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-neutral-900">No non-individual bankruptcy records</h3>
                        <p class="mt-1 text-sm text-neutral-700">Get started by uploading new data.</p>
                        <div class="mt-6">
                            <a href="{{ route('non-individual-bankruptcy.create') }}" class="professional-button-primary">
                                <i class="fas fa-plus mr-2"></i>
                                Upload New Data
                            </a>
                        </div>
                    </div>
                @endif
                </div> <!-- End of mainNonIndividualRecordsTable -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nonIndividualBankruptcySearchForm = document.getElementById('nonIndividualBankruptcySearchForm');
    const nonIndividualBankruptcySearchResults = document.getElementById('nonIndividualBankruptcySearchResults');
    const nonIndividualBankruptcySearchResultsBody = document.getElementById('nonIndividualBankruptcySearchResultsBody');
    const nonIndividualBankruptcyNoResults = document.getElementById('nonIndividualBankruptcyNoResults');
    const nonIndividualBankruptcyLoadingSpinner = document.getElementById('nonIndividualBankruptcyLoadingSpinner');
    const mainNonIndividualRecordsTable = document.getElementById('mainNonIndividualRecordsTable');
    const searchInput = document.getElementById('non_individual_bankruptcy_search_input');
    const clearSearchBtn = document.getElementById('clearNonIndividualSearchBtn');
    const clearSearchResultsBtn = document.getElementById('clearSearchResultsBtn');

    // Debug: Check if elements exist
    console.log('Non-individual bankruptcy elements found:', {
        nonIndividualBankruptcySearchForm: !!nonIndividualBankruptcySearchForm,
        searchInput: !!searchInput,
        clearSearchBtn: !!clearSearchBtn,
        mainNonIndividualRecordsTable: !!mainNonIndividualRecordsTable
    });

    // Check if required elements exist
    if (!searchInput || !clearSearchBtn || !mainNonIndividualRecordsTable) {
        console.error('Required non-individual bankruptcy elements not found');
        return;
    }

    // Test function to manually trigger clear (for debugging)
    window.testNonIndividualClearButton = function() {
        console.log('Testing non-individual clear button manually');
        if (clearSearchBtn) {
            clearSearchBtn.click();
        }
    };

    // Handle form submission
    nonIndividualBankruptcySearchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const searchValue = formData.get('search_input');
        
        if (!searchValue) {
            alert('Please enter a search value.');
            return;
        }
        
        // Hide all previous results and show loading
        nonIndividualBankruptcyLoadingSpinner.classList.remove('hidden');
        nonIndividualBankruptcySearchResults.classList.add('hidden');
        nonIndividualBankruptcyNoResults.classList.add('hidden');
        mainNonIndividualRecordsTable.classList.add('hidden');
        
        fetch('{{ route("non-individual-bankruptcy.search") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            nonIndividualBankruptcyLoadingSpinner.classList.add('hidden');
            
            if (data.success) {
                if (data.results && data.results.length > 0) {
                    displayNonIndividualBankruptcyResults(data.results);
                } else {
                    showNonIndividualBankruptcyNoResults();
                }
            } else {
                alert('Search failed: ' + (data.message || 'Unknown error'));
                showMainNonIndividualTable();
            }
        })
        .catch(error => {
            nonIndividualBankruptcyLoadingSpinner.classList.add('hidden');
            showMainNonIndividualTable();
            console.error('Error:', error);
            alert('An error occurred while searching. Please try again.');
        });
    });

    function displayNonIndividualBankruptcyResults(results) {
        // Clear previous results
        nonIndividualBankruptcySearchResultsBody.innerHTML = '';
        nonIndividualBankruptcyNoResults.classList.add('hidden');
        
        // Update results header with count
        const resultsCount = results.length;
        const resultsHeader = nonIndividualBankruptcySearchResults.querySelector('h3');
        const resultsSubtext = nonIndividualBankruptcySearchResults.querySelector('p');
        
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
                    <div class="text-sm font-medium text-neutral-900">${result.company_name || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-800 font-mono">${result.company_registration_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-800">${result.court_case_no || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-800">${result.date_of_winding_up_resolution ? new Date(result.date_of_winding_up_resolution).toLocaleDateString() : 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-neutral-800">${result.updated_date ? new Date(result.updated_date).toLocaleDateString() : 'N/A'}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-3">
                        <a href="/non-individual-bankruptcy/${result.id}" class="text-neutral-800 hover:text-neutral-700 transition-colors duration-200 font-medium">View</a>
                        <a href="/non-individual-bankruptcy/${result.id}/edit" class="text-green-600 hover:text-green-700 transition-colors duration-200 font-medium">Edit</a>
                    </div>
                </td>
            `;
            nonIndividualBankruptcySearchResultsBody.appendChild(row);
        });
        
        nonIndividualBankruptcySearchResults.classList.remove('hidden');
    }

    function showNonIndividualBankruptcyNoResults() {
        nonIndividualBankruptcySearchResults.classList.add('hidden');
        nonIndividualBankruptcyNoResults.classList.remove('hidden');
    }

    function showMainNonIndividualTable() {
        nonIndividualBankruptcySearchResults.classList.add('hidden');
        nonIndividualBankruptcyNoResults.classList.add('hidden');
        mainNonIndividualRecordsTable.classList.remove('hidden');
    }

    function clearNonIndividualSearch() {
        console.log('Clear non-individual search function called'); // Debug log
        try {
            searchInput.value = '';
            showMainNonIndividualTable();
            clearSearchBtn.style.display = 'none';
            console.log('Clear non-individual search completed successfully');
        } catch (error) {
            console.error('Error in clearNonIndividualSearch:', error);
        }
    }

    // Clear button functionality
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Non-individual clear button clicked'); // Debug log
            clearNonIndividualSearch();
        });
        console.log('Non-individual clear button event listener added');
    } else {
        console.error('Non-individual clear button not found');
    }

    // Clear search results button functionality
    if (clearSearchResultsBtn) {
        clearSearchResultsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Clear search results button clicked');
            clearNonIndividualSearch();
        });
        console.log('Clear search results button event listener added');
    } else {
        console.error('Clear search results button not found');
    }

    // Show/hide clear button based on input
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            console.log('Non-individual input changed:', this.value); // Debug log
            if (this.value.trim() !== '') {
                clearSearchBtn.style.display = 'block';
                console.log('Non-individual clear button shown');
            } else {
                clearSearchBtn.style.display = 'none';
                console.log('Non-individual clear button hidden');
            }
        });
        console.log('Non-individual input event listener added');
    } else {
        console.error('Non-individual search input not found');
    }
});

function confirmDeactivate(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Are you sure?',
        text: "This record will be deactivated and cannot be reverted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, deactivate it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.closest('form').submit();
        }
    });
}
</script>
@endsection
