@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                Welcome back, {{ $user->name }}!
            </h1>
            <p class="text-gray-600">
                You are logged in as a <span class="font-medium {{ $user->isAdmin() ? 'text-purple-600' : 'text-green-600' }}">{{ ucfirst($user->role) }}</span>
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Users Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Total Users
                            </dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ \App\Models\User::count() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Active Users
                            </dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ \App\Models\User::where('is_active', true)->count() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Users Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Admin Users
                            </dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ \App\Models\User::where('role', 'admin')->count() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Annulment Individuals Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Total Annulment Individuals
                            </dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ \App\Models\AnnulmentIndv::where('is_active', true)->count() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information and Quick Actions Side by Side -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Information Card -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Your Account Information
                </h3>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Quick Actions
                </h3>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('annulment-indv.index') }}" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Manage Annulment Individuals
                    </a>
                    
                    <a href="{{ route('bankruptcy.index') }}" class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Manage Individual Bankruptcy Records
                    </a>
                    
                    <a href="{{ route('non-individual-bankruptcy.index') }}" class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Manage Non Individual Bankruptcy Records
                    </a>
                    
                    <button class="btn-outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Update Profile
                    </button>
                    
                    <button class="btn-outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Change Password
                    </button>
                    
                    @if($user->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Admin Panel
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form Section -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                Search Records
            </h3>
            <form id="searchForm" class="space-y-4">
                @csrf
                <div>
                    <label for="ic_number" class="block text-sm font-medium text-gray-700 mb-2">
                        IC Number
                    </label>
                    <input type="text" 
                           id="ic_number" 
                           name="ic_number" 
                           class="form-input w-full max-w-md" 
                           placeholder="Enter IC number (e.g., 123456789012)"
                           required>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <button type="submit" 
                            name="search_type" 
                            value="bankruptcy"
                            class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search Bankruptcy
                    </button>
                    
                    <button type="submit" 
                            name="search_type" 
                            value="annulment"
                            class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Search Annulment (Release)
                    </button>
                </div>
            </form>
            
            <!-- Search Results Table -->
            <div id="searchResults" class="mt-6 hidden">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Search Results</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="searchResultsBody" class="bg-white divide-y divide-gray-200">
                            <!-- Results will be populated here -->
                        </tbody>
                    </table>
                </div>
                <div id="noResults" class="text-center py-8 text-gray-500 hidden">
                    No records found for the provided IC number.
                </div>
            </div>
            
            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="mt-6 text-center hidden">
                <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Searching...
                </div>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Record Details</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div id="modalContent" class="space-y-4">
                    <!-- Content will be populated here -->
                </div>
                
                <div class="flex justify-end mt-6">
                    <button id="closeModalBtn" class="btn-outline">
                        Close
                    </button>
                </div>
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

    // Handle form submission
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get the clicked button to determine search type
        const clickedButton = e.submitter;
        const searchType = clickedButton ? clickedButton.value : null;
        
        const formData = new FormData(this);
        const icNumber = formData.get('ic_number');
        
        // Ensure search_type is set
        if (searchType) {
            formData.set('search_type', searchType);
        }
        
        // Debug logging
        console.log('Form data:', {
            ic_number: icNumber,
            search_type: searchType,
            clicked_button: clickedButton ? clickedButton.name : 'none'
        });
        
        // Validate required fields
        if (!icNumber || !searchType) {
            alert('Please enter an IC number and select a search type.');
            return;
        }
        
        // Show loading spinner
        loadingSpinner.classList.remove('hidden');
        searchResults.classList.add('hidden');
        noResults.classList.add('hidden');
        
        // Make AJAX request
        fetch('{{ route("search") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            loadingSpinner.classList.add('hidden');
            
            if (data.success) {
                if (data.results && data.results.length > 0) {
                    displayResults(data.results);
                } else {
                    showNoResults();
                }
            } else {
                alert('Search failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            loadingSpinner.classList.add('hidden');
            console.error('Error:', error);
            alert('An error occurred while searching. Please try again. Error: ' + error.message);
        });
    });

    function displayResults(results) {
        searchResultsBody.innerHTML = '';
        
        results.forEach(result => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 cursor-pointer';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${result.ic_no || 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${result.name || 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Active
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${result.created_at ? new Date(result.created_at).toLocaleDateString() : 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="showDetails(${result.id})" class="text-indigo-600 hover:text-indigo-900">
                        View Details
                    </button>
                </td>
            `;
            searchResultsBody.appendChild(row);
        });
        
        searchResults.classList.remove('hidden');
    }

    function showNoResults() {
        noResults.classList.remove('hidden');
        searchResults.classList.remove('hidden');
    }

    // Global function for showing details
    window.showDetails = function(id) {
        fetch(`{{ route('search.details', '') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayModal(data.record);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while fetching details.');
        });
    };

    function displayModal(record) {
        modalContent.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">IC Number</label>
                    <p class="mt-1 text-sm text-gray-900">${record.ic_no || 'N/A'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="mt-1 text-sm text-gray-900">${record.name || 'N/A'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Annulment ID</label>
                    <p class="mt-1 text-sm text-gray-900">${record.annulment_indv_id || 'N/A'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Position</label>
                    <p class="mt-1 text-sm text-gray-900">${record.annulment_indv_position || 'N/A'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Branch</label>
                    <p class="mt-1 text-sm text-gray-900">${record.annulment_indv_branch || 'N/A'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Court Case Number</label>
                    <p class="mt-1 text-sm text-gray-900">${record.court_case_number || 'N/A'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">RO Date</label>
                    <p class="mt-1 text-sm text-gray-900">${record.ro_date ? new Date(record.ro_date).toLocaleDateString() : 'N/A'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">AO Date</label>
                    <p class="mt-1 text-sm text-gray-900">${record.ao_date ? new Date(record.ao_date).toLocaleDateString() : 'N/A'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Updated Date</label>
                    <p class="mt-1 text-sm text-gray-900">${record.updated_date ? new Date(record.updated_date).toLocaleDateString() : 'N/A'}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Branch Name</label>
                    <p class="mt-1 text-sm text-gray-900">${record.branch_name || 'N/A'}</p>
                </div>
            </div>
        `;
        
        detailsModal.classList.remove('hidden');
    }

    // Close modal functionality
    closeModal.addEventListener('click', function() {
        detailsModal.classList.add('hidden');
    });

    closeModalBtn.addEventListener('click', function() {
        detailsModal.classList.add('hidden');
    });

    // Close modal when clicking outside
    detailsModal.addEventListener('click', function(e) {
        if (e.target === detailsModal) {
            detailsModal.classList.add('hidden');
        }
    });
});
</script>

@endsection
