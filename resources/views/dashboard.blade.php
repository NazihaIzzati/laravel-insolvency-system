@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $user->name }}</h1>
                    <p class="text-gray-600 mt-1">Here's what's happening with your insolvency data system today.</p>
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
            <!-- Total Records -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Records</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\AnnulmentIndv::count() + \App\Models\AnnulmentNonIndv::count() + \App\Models\Bankruptcy::count() + \App\Models\NonIndividualBankruptcy::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-database text-orange-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+12%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Active Records -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Records</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\AnnulmentIndv::where('is_active', true)->count() + \App\Models\AnnulmentNonIndv::where('is_active', true)->count() + \App\Models\Bankruptcy::where('is_active', true)->count() + \App\Models\NonIndividualBankruptcy::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+8%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Individual Records -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Individual Records</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\AnnulmentIndv::where('is_active', true)->count() + \App\Models\Bankruptcy::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+5%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Company Records -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Company Records</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\AnnulmentNonIndv::where('is_active', true)->count() + \App\Models\NonIndividualBankruptcy::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+3%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Quick Actions</h2>
                <p class="text-sm text-gray-600 mt-1">Access your most used features</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('annulment-indv.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-orange-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-100 transition-colors duration-200">
                            <i class="fas fa-user-check text-orange-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">Individual Annulment</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage individual annulment records</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\AnnulmentIndv::where('is_active', true)->count() }} active records</div>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 transition-colors duration-200"></i>
                    </a>

                    <a href="{{ route('annulment-non-indv.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-orange-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-100 transition-colors duration-200">
                            <i class="fas fa-building text-orange-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">Company Annulment</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage company annulment records</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\AnnulmentNonIndv::where('is_active', true)->count() }} active records</div>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 transition-colors duration-200"></i>
                    </a>

                    <a href="{{ route('bankruptcy.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-orange-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-100 transition-colors duration-200">
                            <i class="fas fa-file-invoice text-orange-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">Individual Bankruptcy</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage individual bankruptcy records</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\Bankruptcy::where('is_active', true)->count() }} active records</div>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 transition-colors duration-200"></i>
                    </a>

                    <a href="{{ route('non-individual-bankruptcy.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-orange-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-100 transition-colors duration-200">
                            <i class="fas fa-industry text-orange-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">Company Bankruptcy</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage company bankruptcy records</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\NonIndividualBankruptcy::where('is_active', true)->count() }} active records</div>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 transition-colors duration-200"></i>
                    </a>

                    @if($user->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-orange-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-100 transition-colors duration-200">
                            <i class="fas fa-cog text-orange-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">Admin Panel</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage system settings and users</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\User::count() }} total users</div>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 transition-colors duration-200"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Universal Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-search text-orange-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Universal Search</h2>
                            <p class="text-sm text-gray-500">Find records across all databases</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center space-x-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle"></i>
                        <span>Search by IC number, name, or company registration</span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <form id="searchForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="search_input" class="block text-sm font-medium text-gray-700 mb-2">
                            Search Records
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="search_input" 
                                   name="search_input" 
                                   class="block w-full pl-10 pr-12 py-3 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200" 
                                   placeholder="Enter IC number, company registration number, or name..."
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
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                <i class="fas fa-id-card mr-1"></i>
                                IC Numbers
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                <i class="fas fa-user mr-1"></i>
                                Names
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                <i class="fas fa-building mr-1"></i>
                                Companies
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                <i class="fas fa-tag mr-1"></i>
                                References
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-100 transition-all duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Search Records
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results -->
        <div id="searchResults" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
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
                    <button type="button" id="clearDashboardSearchResultsBtn" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Clear Results
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name/Company</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC/Registration No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Release Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="searchResultsBody" class="bg-white divide-y divide-gray-200">
                        <!-- Results will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No Results -->
        <div id="noResults" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-12 mb-8">
            <div class="text-center max-w-2xl mx-auto">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Records Found</h3>
                <p class="text-gray-500 mb-6">We couldn't find any records matching your search criteria.</p>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Try searching with:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-600">
                        <div>• Different keywords</div>
                        <div>• Check for typos</div>
                        <div>• Partial matches</div>
                        <div>• Different formats</div>
                    </div>
                </div>
                
                <button type="button" id="clearSearchFromNoResults" class="mt-6 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-redo mr-2"></i>
                    Try Different Search
                </button>
            </div>
        </div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-12 mb-8">
            <div class="text-center">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-spinner fa-spin text-orange-500 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Searching Records</h3>
                <p class="text-gray-500">Please wait while we search for matching records...</p>
            </div>
        </div>

    </div>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="professional-modal hidden">
    <div class="professional-modal-content">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Record Details</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="modalContent" class="space-y-4">
                <!-- Content will be populated here -->
            </div>
            
            <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                <button id="closeModalBtn" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchResults = document.getElementById('searchResults');
    const searchResultsBody = document.getElementById('searchResultsBody');
    const noResults = document.getElementById('noResults');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const detailsModal = document.getElementById('detailsModal');
    const modalContent = document.getElementById('modalContent');
    const closeModal = document.getElementById('closeModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const clearDashboardSearchResultsBtn = document.getElementById('clearDashboardSearchResultsBtn');

    // Initialize modal as hidden
    detailsModal.classList.add('hidden');

    // Handle form submission
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const searchInput = formData.get('search_input');
        
        if (!searchInput) {
            alert('Please enter a search value.');
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
            alert('An error occurred while searching. Please try again.');
        });
    });

    // Clear search results button functionality
    if (clearDashboardSearchResultsBtn) {
        clearDashboardSearchResultsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearDashboardSearch();
        });
    }

    // Clear search from no results button functionality
    const clearSearchFromNoResults = document.getElementById('clearSearchFromNoResults');
    if (clearSearchFromNoResults) {
        clearSearchFromNoResults.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearDashboardSearch();
        });
    }

    // Clear search input button functionality
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const searchInput = document.getElementById('search_input');
    
    if (clearSearchBtn && searchInput) {
        clearSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearDashboardSearch();
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

    function clearDashboardSearch() {
        try {
            if (searchInput) {
                searchInput.value = '';
                clearSearchBtn.style.display = 'none';
            }
            searchResults.classList.add('hidden');
            noResults.classList.add('hidden');
            loadingSpinner.classList.add('hidden');
        } catch (error) {
            console.error('Error in clearDashboardSearch:', error);
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
            row.className = 'hover:bg-gray-50 transition-colors duration-200';
            
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
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8">
                            <div class="h-8 w-8 rounded-full bg-orange-100 flex items-center justify-center">
                                <span class="text-xs font-medium text-orange-600">${(name || 'N/A').charAt(0).toUpperCase()}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">${name}</div>
                            <div class="text-xs text-gray-500">${type} Record</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 bg-gray-50 px-2 py-1 rounded-md inline-block">${identifier}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium ${typeBg} ${typeColor}">
                        ${type}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        ${releaseType !== 'N/A' ? 
                            `<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-md text-xs">${releaseType}</span>` : 
                            '<span class="text-gray-400">N/A</span>'
                        }
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="showDetails(${result.id}, '${result.table_name || ''}')" class="inline-flex items-center px-3 py-1 text-xs font-medium text-orange-600 bg-orange-50 rounded-md hover:bg-orange-100 transition-colors duration-200">
                        <i class="fas fa-eye mr-1"></i>
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
        detailsModal.classList.add('hidden');
        
        let url = `{{ route('search.details', '') }}/${id}`;
        if (tableName) {
            url += `?table=${encodeURIComponent(tableName)}`;
        }
        
        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayModal(data.record);
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
        } else {
            modalContentHTML = `
                <div class="space-y-4">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
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
        }
        
        modalContent.innerHTML = modalContentHTML;
        detailsModal.classList.remove('hidden');
    }

    // Close modal functionality
    closeModal.addEventListener('click', function() {
        detailsModal.classList.add('hidden');
    });

    closeModalBtn.addEventListener('click', function() {
        detailsModal.classList.add('hidden');
    });

    detailsModal.addEventListener('click', function(e) {
        if (e.target === detailsModal) {
            detailsModal.classList.add('hidden');
        }
    });
});
</script>
@endsection