@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                    <p class="text-gray-600 mt-1">System administration panel for managing users and system settings.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden lg:flex items-center space-x-2 text-sm text-gray-500">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span>System Online</span>
                    </div>
                    <div class="text-sm text-gray-500">{{ now()->format('M d, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-group text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+12%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Active Users -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Users</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+8%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Admin Users</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::whereIn('role', ['admin', 'superuser'])->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-shield text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+2%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Staff Users -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Staff Users</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::whereIn('role', ['staff', 'id_management'])->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user text-orange-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+15%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Admin Actions</h2>
                <p class="text-sm text-gray-600 mt-1">Manage bankruptcy and annulment records</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Individual Bankruptcy -->
                    <a href="{{ route('bankruptcy.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-red-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-red-100 transition-colors duration-200">
                            <i class="bx bx-user-x text-red-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-red-600 transition-colors duration-200">Individual Bankruptcy</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage individual bankruptcy records</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\Bankruptcy::where('is_active', true)->count() }} active records</div>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-red-600 transition-colors duration-200"></i>
                    </a>

                    <!-- Non-Individual Bankruptcy -->
                    <a href="{{ route('non-individual-bankruptcy.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-red-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-red-100 transition-colors duration-200">
                            <i class="bx bx-buildings text-red-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-red-600 transition-colors duration-200">Non-Individual Bankruptcy</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage company bankruptcy records</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\NonIndividualBankruptcy::where('is_active', true)->count() }} active records</div>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-red-600 transition-colors duration-200"></i>
                    </a>

                    <!-- Individual Release -->
                    <a href="{{ route('annulment-indv.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-green-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-100 transition-colors duration-200">
                            <i class="bx bx-user-check text-green-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">Individual Release</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage individual annulment records</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\AnnulmentIndv::where('is_active', true)->count() }} active records</div>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-green-600 transition-colors duration-200"></i>
                    </a>

                    <!-- Non-Individual Release -->
                    <a href="{{ route('annulment-non-indv.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-green-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-100 transition-colors duration-200">
                            <i class="bx bx-building text-green-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">Non-Individual Release</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage company annulment records</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\AnnulmentNonIndv::where('is_active', true)->count() }} active records</div>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-green-600 transition-colors duration-200"></i>
                    </a>
                </div>
            </div>
        </div>


        <!-- Universal Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="bx bx-search text-orange-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Search Records</h2>
                            <p class="text-sm text-gray-500">Find bankruptcy and annulment records</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center space-x-2 text-sm text-gray-500">
                        <i class="bx bx-info-circle"></i>
                        <span>Search by IC number, name, or company registration</span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <form id="adminSearchForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="admin_search_input" class="block text-sm font-medium text-gray-700 mb-2">
                            Search Records
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bx bx-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="admin_search_input" 
                                   name="search_input" 
                                    class="block w-full pl-10 pr-12 py-3 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200"
                                   placeholder="Enter IC number, company registration number, or name..."
                                   required>
                            <button type="button" 
                                    id="admin_clearSearchBtn" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200" 
                                    style="display: none;" 
                                    title="Clear search">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        
                        <!-- Search Tags -->
                        <div class="mt-3 flex flex-wrap gap-2">
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                <i class="bx bx-id-card mr-1"></i>
                                IC Numbers
                            </span>
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                <i class="bx bx-user mr-1"></i>
                                Names
                            </span>
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                <i class="bx bx-buildings mr-1"></i>
                                Companies
                            </span>
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                                <i class="bx bx-purchase-tag mr-1"></i>
                                References
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="bx bx-search mr-2"></i>
                            Search Records
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results -->
        <div id="adminSearchResults" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="bx bx-check-circle text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Search Results</h3>
                            <p class="text-sm text-gray-500">Matching records found</p>
                        </div>
                    </div>
                    <button type="button" id="admin_clearSearchResultsBtn" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-white transition-colors duration-200">
                        <i class="bx bx-x mr-2"></i>
                        Clear Results
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name/Company</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC/Registration No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Release Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="adminSearchResultsBody" class="bg-white divide-y divide-gray-200">
                        <!-- Results will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No Results -->
        <div id="adminNoResults" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-12 mb-8">
            <div class="text-center max-w-2xl mx-auto">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bx bx-search text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Records Found</h3>
                <p class="text-gray-500 mb-6">We couldn't find any records matching your search criteria.</p>
                
                <button type="button" id="admin_clearSearchFromNoResults" class="mt-6 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-white transition-colors duration-200">
                    <i class="bx bx-refresh mr-2"></i>
                    Try Different Search
                </button>
            </div>
        </div>

        <!-- Loading Spinner -->
        <div id="adminLoadingSpinner" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-12 mb-8">
            <div class="text-center">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bx bx-loader-alt bx-spin text-orange-500 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Searching Records</h3>
                <p class="text-gray-500">Please wait while we search for matching records...</p>
            </div>
        </div>


    </div>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="fixed inset-0 bg-slate-500 bg-opacity-40 overflow-y-auto h-full w-full z-50 hidden flex items-center justify-center p-4">
    <div class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-slate-200">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-slate-800">Record Details</h3>
                <button id="closeModal" class="text-slate-400 hover:text-slate-600 transition-colors duration-200 p-1 rounded-lg hover:bg-slate-100">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>
            
            <div id="modalContent" class="space-y-4 mb-6">
                <!-- Content will be populated here -->
            </div>
            
            <div class="flex justify-center pt-4 border-t border-slate-200">
                <button id="printModalBtn" class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 shadow-sm">
                    <i class="bx bx-printer mr-2 text-lg"></i>
                    Print Record
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printableContent, #printableContent * {
        visibility: visible;
    }
    #printableContent {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('adminSearchForm');
    const searchResults = document.getElementById('adminSearchResults');
    const searchResultsBody = document.getElementById('adminSearchResultsBody');
    const noResults = document.getElementById('adminNoResults');
    const loadingSpinner = document.getElementById('adminLoadingSpinner');
    const clearSearchBtn = document.getElementById('admin_clearSearchBtn');
    const searchInput = document.getElementById('admin_search_input');
    const clearSearchResultsBtn = document.getElementById('admin_clearSearchResultsBtn');
    const clearSearchFromNoResults = document.getElementById('admin_clearSearchFromNoResults');

    // Handle form submission
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const searchInputValue = formData.get('search_input');
        
        if (!searchInputValue) {
            Swal.fire({
                title: 'Search Required',
                text: 'Please enter a search value.',
                icon: 'warning',
                confirmButtonColor: '#ea580c',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        loadingSpinner.classList.remove('hidden');
        searchResults.classList.add('hidden');
        noResults.classList.add('hidden');
        
        // Search both bankruptcy and annulment records
        Promise.all([
            fetch('{{ route("search") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }),
            fetch('{{ route("search.annulment") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
        ])
        .then(responses => Promise.all(responses.map(response => response.json())))
        .then(([bankruptcyData, annulmentData]) => {
            loadingSpinner.classList.add('hidden');
            
            // Combine results from both searches
            let allResults = [];
            
            if (bankruptcyData.success && bankruptcyData.results) {
                allResults = allResults.concat(bankruptcyData.results);
            }
            
            if (annulmentData.success && annulmentData.results) {
                allResults = allResults.concat(annulmentData.results);
            }
            
            // Remove duplicates based on IC number or company registration number
            const uniqueResults = [];
            const seenIdentifiers = new Set();
            
            allResults.forEach(result => {
                const identifier = result.ic_no || result.company_registration_no;
                if (identifier && !seenIdentifiers.has(identifier)) {
                    seenIdentifiers.add(identifier);
                    uniqueResults.push(result);
                }
            });
            
            if (uniqueResults.length > 0) {
                displayResults(uniqueResults);
            } else {
                showNoResults();
            }
        })
        .catch(error => {
            loadingSpinner.classList.add('hidden');
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

    // Clear search results button functionality
    if (clearSearchResultsBtn) {
        clearSearchResultsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearSearch();
        });
    }

    // Clear search from no results button functionality
    if (clearSearchFromNoResults) {
        clearSearchFromNoResults.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearSearch();
        });
    }

    // Clear search input button functionality
    if (clearSearchBtn && searchInput) {
        clearSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearSearch();
        });

        // Show/hide clear button based on input content
        searchInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                clearSearchBtn.style.display = 'block';
            } else {
                clearSearchBtn.style.display = 'none';
            }
        });
    }

    function clearSearch() {
        try {
            if (searchInput) {
                searchInput.value = '';
                clearSearchBtn.style.display = 'none';
            }
            searchResults.classList.add('hidden');
            noResults.classList.add('hidden');
            loadingSpinner.classList.add('hidden');
        } catch (error) {
            console.error('Error in clearSearch:', error);
        }
    }

    function displayResults(results) {
        searchResultsBody.innerHTML = '';
        
        // Update results count in header
        const resultsCount = results.length;
        const resultsHeader = searchResults.querySelector('h3');
        const resultsSubtext = searchResults.querySelector('p');
        
        if (resultsCount === 1) {
            resultsHeader.textContent = 'Search Results';
            resultsSubtext.textContent = '1 matching record found';
        } else {
            resultsHeader.textContent = 'Search Results';
            resultsSubtext.textContent = `${resultsCount} matching records found`;
        }
        
        results.forEach((result, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-white transition-colors duration-200';
            
            let identifier, name, type, releaseType, typeColor, typeBg;
            
            if (result.ic_no) {
                identifier = result.ic_no;
                name = result.name || 'N/A';
                type = result.record_type === 'annulment' ? 'Annulment' : 'Individual Bankruptcy';
                releaseType = result.release_type || 'N/A';
                
                if (type === 'Annulment') {
                    typeColor = 'text-green-700';
                    typeBg = 'bg-green-100';
                } else {
                    typeColor = 'text-red-700';
                    typeBg = 'bg-red-100';
                }
            } else if (result.company_registration_no) {
                identifier = result.company_registration_no;
                name = result.company_name || 'N/A';
                type = 'Non-Individual Bankruptcy';
                releaseType = 'N/A';
                typeColor = 'text-gray-700';
                typeBg = 'bg-gray-100';
            } else {
                identifier = 'N/A';
                name = 'N/A';
                type = 'Unknown';
                releaseType = 'N/A';
                typeColor = 'text-gray-700';
                typeBg = 'bg-gray-100';
            }
            
            row.innerHTML = `
                <td class="px-4 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 relative">
                            <div class="h-8 w-8 rounded-full bg-orange-100 flex items-center justify-center">
                                <span class="text-xs font-medium text-orange-600">${(name || 'N/A').charAt(0).toUpperCase()}</span>
                            </div>
                            <div class="absolute -top-1 -right-1 h-3 w-3 bg-red-500 rounded-full"></div>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">${name}</div>
                            <div class="text-xs text-gray-500">${type} Record</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div class="text-sm text-gray-900">${identifier}</div>
                </td>
                <td class="px-4 py-4">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${typeBg} ${typeColor}">
                        ${type}
                    </span>
                </td>
                <td class="px-4 py-4">
                    <div class="text-sm text-gray-900">
                        ${releaseType !== 'N/A' ? releaseType : 'N/A'}
                    </div>
                </td>
                <td class="px-4 py-4">
                    <button onclick="showDetails(${result.id}, '${result.table_name || ''}')" class="inline-flex items-center px-3 py-1 text-xs font-medium text-orange-600 bg-orange-50 rounded-md hover:bg-orange-100 transition-colors duration-200">
                        <i class="bx bx-show mr-1"></i>
                        View
                    </button>
                </td>
            `;
            searchResultsBody.appendChild(row);
        });
        
        searchResults.classList.remove('hidden');
    }

    function showNoResults() {
        noResults.classList.remove('hidden');
        searchResults.classList.add('hidden');
    }

    // Global function for showing details
    window.showDetails = function(id, tableName = '') {
        const detailsModal = document.getElementById('detailsModal');
        const modalContent = document.getElementById('modalContent');
        
        if (detailsModal) {
            detailsModal.classList.add('hidden');
        }
        
        let url = `{{ route('search.details', '') }}/${id}`;
        if (tableName) {
            url += `?table=${encodeURIComponent(tableName)}`;
        }
        
        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayModal(data.record);
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'Record not found.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while fetching details.',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK'
            });
        });
    };

    function displayModal(record) {
        let recordType = record.record_type || 'unknown';
        let modalContentHTML = '';
        let printContentHTML = '';
        
        if (recordType === 'non-individual-bankruptcy' || (record.company_name && record.company_registration_no)) {
            modalContentHTML = `
                <div class="space-y-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-blue-900 mb-3">Non-Individual Bankruptcy Details</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-blue-700 font-medium">Insolvency No:</span>
                                <span class="text-blue-900">${record.insolvency_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-blue-700 font-medium">Company Name:</span>
                                <span class="text-blue-900">${record.company_name || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-blue-700 font-medium">Company Registration No:</span>
                                <span class="text-blue-900">${record.company_registration_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-blue-700 font-medium">Court Case No:</span>
                                <span class="text-blue-900">${record.court_case_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-blue-700 font-medium">Branch:</span>
                                <span class="text-blue-900">${record.branch || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            printContentHTML = `
                <div id="printableContent" class="p-8">
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Non-Individual Bankruptcy Record</h1>
                        <p class="text-gray-600">Generated on ${new Date().toLocaleDateString()}</p>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Record Details</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Insolvency No:</span>
                                <span class="text-gray-900">${record.insolvency_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Company Name:</span>
                                <span class="text-gray-900">${record.company_name || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Company Registration No:</span>
                                <span class="text-gray-900">${record.company_registration_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Court Case No:</span>
                                <span class="text-gray-900">${record.court_case_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Branch:</span>
                                <span class="text-gray-900">${record.branch || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (recordType === 'bankruptcy' || record.insolvency_no || record.ro_date || record.ao_date) {
            modalContentHTML = `
                <div class="space-y-4">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-red-900 mb-3">Bankruptcy Details</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-red-700 font-medium">Insolvency No:</span>
                                <span class="text-red-900">${record.insolvency_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-red-700 font-medium">Name:</span>
                                <span class="text-red-900">${record.name || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-red-700 font-medium">IC Number:</span>
                                <span class="text-red-900">${record.ic_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-red-700 font-medium">Court Case No:</span>
                                <span class="text-red-900">${record.court_case_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-red-700 font-medium">Branch:</span>
                                <span class="text-red-900">${record.branch || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            printContentHTML = `
                <div id="printableContent" class="p-8">
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Bankruptcy Record</h1>
                        <p class="text-gray-600">Generated on ${new Date().toLocaleDateString()}</p>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Record Details</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Insolvency No:</span>
                                <span class="text-gray-900">${record.insolvency_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Name:</span>
                                <span class="text-gray-900">${record.name || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">IC Number:</span>
                                <span class="text-gray-900">${record.ic_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Court Case No:</span>
                                <span class="text-gray-900">${record.court_case_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Branch:</span>
                                <span class="text-gray-900">${record.branch || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (recordType === 'annulment' || record.release_date || record.release_type) {
            modalContentHTML = `
                <div class="space-y-4">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-green-900 mb-3">Annulment Details</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-green-700 font-medium">Name:</span>
                                <span class="text-green-900">${record.name || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-700 font-medium">IC Number:</span>
                                <span class="text-green-900">${record.ic_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-700 font-medium">Court Case No:</span>
                                <span class="text-green-900">${record.court_case_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-700 font-medium">Release Date:</span>
                                <span class="text-green-900">${record.release_date ? new Date(record.release_date).toLocaleDateString() : 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-700 font-medium">Release Type:</span>
                                <span class="text-green-900">${record.release_type || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-700 font-medium">Branch:</span>
                                <span class="text-green-900">${record.branch || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            printContentHTML = `
                <div id="printableContent" class="p-8">
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Annulment Record</h1>
                        <p class="text-gray-600">Generated on ${new Date().toLocaleDateString()}</p>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Record Details</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Name:</span>
                                <span class="text-gray-900">${record.name || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">IC Number:</span>
                                <span class="text-gray-900">${record.ic_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Court Case No:</span>
                                <span class="text-gray-900">${record.court_case_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Release Date:</span>
                                <span class="text-gray-900">${record.release_date ? new Date(record.release_date).toLocaleDateString() : 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Release Type:</span>
                                <span class="text-gray-900">${record.release_type || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Branch:</span>
                                <span class="text-gray-900">${record.branch || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            modalContentHTML = `
                <div class="space-y-4">
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">Record Details</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                 <span class="text-gray-700 font-medium">Name:</span>
                                <span class="text-gray-900">${record.name || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700 font-medium">IC Number:</span>
                                <span class="text-gray-900">${record.ic_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700 font-medium">Court Case No:</span>
                                <span class="text-gray-900">${record.court_case_no || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            printContentHTML = `
                <div id="printableContent" class="p-8">
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Record Details</h1>
                        <p class="text-gray-600">Generated on ${new Date().toLocaleDateString()}</p>
                    </div>
                    <div class="bg-white border border-gray-300 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Record Information</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Name:</span>
                                <span class="text-gray-900">${record.name || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">IC Number:</span>
                                <span class="text-gray-900">${record.ic_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="font-medium text-gray-700">Court Case No:</span>
                                <span class="text-gray-900">${record.court_case_no || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Store print content for later use
        window.currentPrintContent = printContentHTML;
        
        modalContent.innerHTML = modalContentHTML;
        detailsModal.classList.remove('hidden');
    }

    // Modal functionality
    const detailsModal = document.getElementById('detailsModal');
    const modalContent = document.getElementById('modalContent');
    const closeModal = document.getElementById('closeModal');

    // Initialize modal as hidden
    if (detailsModal) {
        detailsModal.classList.add('hidden');
    }

    // Close modal functionality
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            detailsModal.classList.add('hidden');
        });
    }

    // Print functionality
    const printModalBtn = document.getElementById('printModalBtn');
    if (printModalBtn) {
        printModalBtn.addEventListener('click', function() {
            printRecord();
        });
    }

    function printRecord() {
        if (window.currentPrintContent) {
            // Create a new window for printing
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Record Details - Print</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 20px;
                            background: white;
                        }
                        .print-header {
                            text-align: center;
                            margin-bottom: 30px;
                            border-bottom: 2px solid #333;
                            padding-bottom: 20px;
                        }
                        .print-content {
                            max-width: 800px;
                            margin: 0 auto;
                        }
                        .record-section {
                            background: #f9f9f9;
                            border: 1px solid #ddd;
                            border-radius: 8px;
                            padding: 20px;
                            margin-bottom: 20px;
                        }
                        .record-title {
                            font-size: 18px;
                            font-weight: bold;
                            color: #333;
                            margin-bottom: 15px;
                        }
                        .record-field {
                            display: flex;
                            justify-content: space-between;
                            padding: 8px 0;
                            border-bottom: 1px solid #e2e8f0;
                        }
                        .record-field:last-child {
                            border-bottom: none;
                        }
                        .field-label {
                            font-weight: 600;
                            color: #475569;
                        }
                        .field-value {
                            color: #1e293b;
                        }
                        @media print {
                            body { margin: 0; }
                            .print-content { max-width: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-content">
                        ${window.currentPrintContent}
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    }

    if (detailsModal) {
        detailsModal.addEventListener('click', function(e) {
            if (e.target === detailsModal) {
                detailsModal.classList.add('hidden');
            }
        });
    }
});
</script>

@endsection

