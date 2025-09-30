@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-primary-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary-900 to-accent-600 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-12">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-4xl font-light mb-3">Dashboard Overview</h1>
                        <p class="text-xl text-primary-100 mb-2">Welcome back, {{ $user->name }}</p>
                        <p class="text-primary-200">Here's what's happening with your system today</p>
                    </div>
                    <div class="text-right text-white">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-6 py-4">
                            <p class="text-sm text-primary-100 mb-1">Last updated</p>
                            <p class="text-lg font-medium">{{ now()->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <!-- Total Users -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">Total Users</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">{{ \App\Models\User::count() }}</p>
                            <p class="text-xs text-green-600 mt-1">+2 this month</p>
                        </div>
                        <div class="professional-stat-icon professional-stat-icon-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">Active Users</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">{{ \App\Models\User::where('is_active', true)->count() }}</p>
                            <p class="text-xs text-green-600 mt-1">All systems operational</p>
                        </div>
                        <div class="professional-stat-icon professional-stat-icon-success">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Admin Users -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">Admin Users</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                            <p class="text-xs text-primary-500 mt-1">Administrative access</p>
                        </div>
                        <div class="professional-stat-icon professional-stat-icon-warning">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Annulment Records -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">Annulment Records</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">{{ \App\Models\AnnulmentIndv::where('is_active', true)->count() }}</p>
                            <p class="text-xs text-blue-600 mt-1">Active cases</p>
                        </div>
                        <div class="professional-stat-icon professional-stat-icon-info">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Account Information -->
                <div class="professional-section">
                    <div class="professional-section-header">
                        <h3 class="text-lg font-medium text-primary-900">Account Information</h3>
                        <p class="text-sm text-primary-500 mt-1">Your profile details and status</p>
                    </div>
                    <div class="professional-section-content">
                        <dl class="space-y-4">
                            <div class="flex items-center justify-between py-2">
                                <dt class="text-sm text-primary-500">Full Name</dt>
                                <dd class="text-sm font-medium text-primary-900">{{ $user->name }}</dd>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <dt class="text-sm text-primary-500">Email Address</dt>
                                <dd class="text-sm font-medium text-primary-900">{{ $user->email }}</dd>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <dt class="text-sm text-primary-500">Role</dt>
                                <dd class="text-sm">
                                    <span class="professional-badge {{ $user->isAdmin() ? 'professional-badge-warning' : 'professional-badge-success' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <dt class="text-sm text-primary-500">Account Status</dt>
                                <dd class="text-sm">
                                    <span class="professional-badge {{ $user->is_active ? 'professional-badge-success' : 'professional-badge-danger' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <dt class="text-sm text-primary-500">Member Since</dt>
                                <dd class="text-sm font-medium text-primary-900">{{ $user->created_at->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="professional-section">
                    <div class="professional-section-header">
                        <h3 class="text-lg font-medium text-primary-900">Quick Actions</h3>
                        <p class="text-sm text-primary-500 mt-1">Access your most used features</p>
                    </div>
                    <div class="professional-section-content">
                        <div class="space-y-3">
                            <a href="{{ route('annulment-indv.index') }}" class="professional-button w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Manage Annulment Records
                            </a>
                            
                            <a href="{{ route('bankruptcy.index') }}" class="professional-button w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Individual Bankruptcy
                            </a>
                            
                            <a href="{{ route('non-individual-bankruptcy.index') }}" class="professional-button w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Non-Individual Bankruptcy
                            </a>
                            
                            @if($user->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="professional-button-accent w-full justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Admin Panel
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="professional-section mt-6">
                <div class="professional-section-header">
                    <h3 class="text-lg font-medium text-primary-900">Search Records</h3>
                    <p class="text-sm text-primary-500 mt-1">Find specific records quickly</p>
                </div>
                <div class="professional-section-content">
                    <form id="searchForm" class="space-y-4">
                        @csrf
                        <div>
                            <label for="search_input" class="block text-sm font-medium text-primary-700 mb-2">
                                Search Query
                            </label>
                            <input type="text" 
                                   id="search_input" 
                                   name="search_input" 
                                   class="professional-input" 
                                   placeholder="Enter IC number or Company Registration"
                                   required>
                            <p class="text-xs text-primary-500 mt-1">Enter an IC number (e.g., 123456789012) or Company Registration Number (e.g., 200601032038)</p>
                        </div>
                        
                        <button type="submit" class="professional-button-primary w-full justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search Records
                        </button>
                    </form>
                    
                    <!-- Search Results -->
                    <div id="searchResults" class="mt-6 hidden">
                        <div class="professional-search-results">
                            <h4 class="text-sm font-medium text-primary-900 mb-4">Search Results</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-primary-200">
                                    <thead class="bg-primary-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Name/Company</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">IC/Registration No</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Type</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchResultsBody" class="bg-white divide-y divide-primary-200">
                                        <!-- Results will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="noResults" class="text-center py-8 text-primary-500 hidden">
                                <svg class="mx-auto h-12 w-12 text-primary-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-sm font-medium">No records found</p>
                                <p class="text-xs text-primary-400 mt-1">Try adjusting your search criteria</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" class="mt-6 text-center hidden">
                        <div class="professional-loading">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-accent-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm font-medium text-primary-700">Searching...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="professional-modal hidden">
    <div class="professional-modal-content">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-medium text-primary-900">Record Details</h3>
                <button id="closeModal" class="text-primary-400 hover:text-primary-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="modalContent" class="space-y-4">
                <!-- Content will be populated here -->
            </div>
            
            <div class="flex justify-end mt-6 pt-4 border-t border-primary-200">
                <button id="closeModalBtn" class="professional-button">
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
        
        fetch('{{ route("search") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
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
            alert('An error occurred while searching. Please try again.');
        });
    });

    function displayResults(results) {
        searchResultsBody.innerHTML = '';
        
        results.forEach(result => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-primary-50 transition-colors duration-200';
            
            let identifier, name, type;
            
            if (result.ic_no) {
                identifier = result.ic_no;
                name = result.name || 'N/A';
                type = result.annulment_indv_id ? 'Annulment' : 'Individual Bankruptcy';
            } else if (result.company_registration_no) {
                identifier = result.company_registration_no;
                name = result.company_name || 'N/A';
                type = 'Non-Individual Bankruptcy';
            } else {
                identifier = 'N/A';
                name = 'N/A';
                type = 'Unknown';
            }
            
            row.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-primary-900">${name}</div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <div class="text-sm text-primary-600">${identifier}</div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <span class="professional-badge ${type === 'Annulment' ? 'professional-badge-info' : type === 'Non-Individual Bankruptcy' ? 'professional-badge-warning' : 'professional-badge-success'}">
                        ${type}
                    </span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                    <button onclick="showDetails(${result.id})" class="text-accent-600 hover:text-accent-700 transition-colors duration-200">
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
        // Ensure modal is hidden first
        detailsModal.classList.add('hidden');
        
        fetch(`{{ route('search.details', '') }}/${id}`)
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
        let fields = [];
        
        if (recordType === 'non-individual-bankruptcy' || (record.company_name && record.company_registration_no)) {
            recordType = 'non-individual-bankruptcy';
            fields = [
                { label: 'Insolvency No', value: record.insolvency_no || 'N/A' },
                { label: 'Company Name', value: record.company_name || 'N/A' },
                { label: 'Company Registration No', value: record.company_registration_no || 'N/A' },
                { label: 'Others', value: record.others || 'N/A' },
                { label: 'Court Case No', value: record.court_case_no || 'N/A' },
                { label: 'Date of Winding Up/Resolution', value: record.date_of_winding_up_resolution ? new Date(record.date_of_winding_up_resolution).toLocaleDateString() : 'N/A' },
                { label: 'Updated Date', value: record.updated_date ? new Date(record.updated_date).toLocaleDateString() : 'N/A' },
                { label: 'Branch', value: record.branch || 'N/A' }
            ];
        } else if (recordType === 'annulment' || record.annulment_indv_id) {
            recordType = 'annulment';
            fields = [
                { label: 'Annulment ID', value: record.annulment_indv_id || 'N/A' },
                { label: 'No Involvency', value: record.no_involvency || 'N/A' },
                { label: 'Name', value: record.name || 'N/A' },
                { label: 'IC Number', value: record.ic_no || 'N/A' },
                { label: 'IC Number 2', value: record.ic_no_2 || 'N/A' },
                { label: 'Position', value: record.annulment_indv_position || 'N/A' },
                { label: 'Branch', value: record.annulment_indv_branch || 'N/A' },
                { label: 'Court Case Number', value: record.court_case_number || 'N/A' },
                { label: 'RO Date', value: record.ro_date ? new Date(record.ro_date).toLocaleDateString() : 'N/A' },
                { label: 'AO Date', value: record.ao_date ? new Date(record.ao_date).toLocaleDateString() : 'N/A' },
                { label: 'Updated Date', value: record.updated_date ? new Date(record.updated_date).toLocaleDateString() : 'N/A' },
                { label: 'Branch Name', value: record.branch_name || 'N/A' }
            ];
        } else if (recordType === 'bankruptcy' || (record.ic_no && record.name)) {
            recordType = 'individual-bankruptcy';
            fields = [
                { label: 'Insolvency No', value: record.insolvency_no || 'N/A' },
                { label: 'Name', value: record.name || 'N/A' },
                { label: 'IC Number', value: record.ic_no || 'N/A' },
                { label: 'Others', value: record.others || 'N/A' },
                { label: 'Court Case No', value: record.court_case_no || 'N/A' },
                { label: 'RO Date', value: record.ro_date ? new Date(record.ro_date).toLocaleDateString() : 'N/A' },
                { label: 'AO Date', value: record.ao_date ? new Date(record.ao_date).toLocaleDateString() : 'N/A' },
                { label: 'Updated Date', value: record.updated_date ? new Date(record.updated_date).toLocaleDateString() : 'N/A' },
                { label: 'Branch', value: record.branch || 'N/A' }
            ];
        } else {
            fields = Object.keys(record).map(key => ({
                label: key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
                value: record[key] || 'N/A'
            }));
        }
        
        let modalContentHTML = `
            <div class="mb-6">
                <span class="professional-badge professional-badge-primary text-sm px-4 py-2">
                    ${recordType.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                </span>
            </div>
            <div class="space-y-4">
        `;
        
        fields.forEach(field => {
            modalContentHTML += `
                <div class="flex justify-between items-start py-3 border-b border-primary-100 last:border-b-0">
                    <dt class="text-sm text-primary-500 font-medium w-1/3">${field.label}</dt>
                    <dd class="text-sm text-primary-900 w-2/3 text-right font-medium">${field.value}</dd>
                </div>
            `;
        });
        
        modalContentHTML += '</div>';
        
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