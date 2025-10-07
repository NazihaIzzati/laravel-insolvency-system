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
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-6 mb-8">
                <!-- Individual Annulment Records -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">Individual Annulment</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">{{ \App\Models\AnnulmentIndv::where('is_active', true)->count() }}</p>
                            <p class="text-xs text-blue-600 mt-1">Active cases</p>
                        </div>
                        <div class="professional-stat-icon professional-stat-icon-info">
                            <i class="fas fa-user-check text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Non-Individual Annulment Records -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">Non-Individual Annulment</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">{{ \App\Models\AnnulmentNonIndv::where('is_active', true)->count() }}</p>
                            <p class="text-xs text-purple-600 mt-1">Company cases</p>
                        </div>
                        <div class="professional-stat-icon professional-stat-icon-info">
                            <i class="fas fa-building text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Individual Bankruptcy Records -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">Individual Bankruptcy</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">{{ \App\Models\Bankruptcy::where('is_active', true)->count() }}</p>
                            <p class="text-xs text-red-600 mt-1">Bankruptcy cases</p>
                        </div>
                        <div class="professional-stat-icon professional-stat-icon-danger">
                            <i class="fas fa-file-invoice text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Non-Individual Bankruptcy Records -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">Non-Individual Bankruptcy</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">{{ \App\Models\NonIndividualBankruptcy::where('is_active', true)->count() }}</p>
                            <p class="text-xs text-orange-600 mt-1">Company bankruptcies</p>
                        </div>
                        <div class="professional-stat-icon professional-stat-icon-warning">
                            <i class="fas fa-industry text-2xl"></i>
                    </div>
                </div>
            </div>

                <!-- Total Records -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">Total Records</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">{{ \App\Models\AnnulmentIndv::where('is_active', true)->count() + \App\Models\AnnulmentNonIndv::where('is_active', true)->count() + \App\Models\Bankruptcy::where('is_active', true)->count() + \App\Models\NonIndividualBankruptcy::where('is_active', true)->count() }}</p>
                            <p class="text-xs text-green-600 mt-1">All systems</p>
                    </div>
                        <div class="professional-stat-icon professional-stat-icon-success">
                            <i class="fas fa-database text-2xl"></i>
                            </div>
                            </div>
                            </div>

                <!-- System Status -->
                <div class="professional-stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-500 uppercase tracking-wide font-medium">System Status</p>
                            <p class="text-2xl font-light text-primary-900 mt-1">Online</p>
                            <p class="text-xs text-green-600 mt-1">All systems operational</p>
                            </div>
                        <div class="professional-stat-icon professional-stat-icon-success">
                            <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                    </div>
                    </div>
                </div>

                <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <!-- Individual Annulment -->
                <a href="{{ route('annulment-indv.index') }}" class="group relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-blue-100/50 transition-all duration-500 transform hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-user-check text-white text-xl"></i>
                    </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ \App\Models\AnnulmentIndv::where('is_active', true)->count() }}
                                </div>
                                <div class="text-xs text-gray-500 font-medium">Active Records</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-300">Individual Annulment</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">Manage and process individual annulment cases with comprehensive tracking and documentation.</p>
                        <div class="flex items-center text-blue-600 text-sm font-semibold group-hover:text-blue-700 transition-colors duration-300">
                            <span>Access Records</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>

                <!-- Non-Individual Annulment -->
                <a href="{{ route('annulment-non-indv.index') }}" class="group relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-purple-100/50 transition-all duration-500 transform hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 via-white to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-300">
                                    {{ \App\Models\AnnulmentNonIndv::where('is_active', true)->count() }}
                                </div>
                                <div class="text-xs text-gray-500 font-medium">Active Records</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors duration-300">Non-Individual Annulment</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">Handle corporate annulment proceedings with advanced case management and reporting tools.</p>
                        <div class="flex items-center text-purple-600 text-sm font-semibold group-hover:text-purple-700 transition-colors duration-300">
                            <span>Access Records</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>

                <!-- Individual Bankruptcy -->
                <a href="{{ route('bankruptcy.index') }}" class="group relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-red-100/50 transition-all duration-500 transform hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-red-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-file-invoice text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 group-hover:text-red-600 transition-colors duration-300">
                                    {{ \App\Models\Bankruptcy::where('is_active', true)->count() }}
                                </div>
                                <div class="text-xs text-gray-500 font-medium">Active Records</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-red-600 transition-colors duration-300">Individual Bankruptcy</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">Process individual bankruptcy cases with detailed financial analysis and legal documentation.</p>
                        <div class="flex items-center text-red-600 text-sm font-semibold group-hover:text-red-700 transition-colors duration-300">
                            <span>Access Records</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>

                <!-- Non-Individual Bankruptcy -->
                <a href="{{ route('non-individual-bankruptcy.index') }}" class="group relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-orange-100/50 transition-all duration-500 transform hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-white to-orange-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-industry text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300">
                                    {{ \App\Models\NonIndividualBankruptcy::where('is_active', true)->count() }}
                                </div>
                                <div class="text-xs text-gray-500 font-medium">Active Records</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-orange-600 transition-colors duration-300">Non-Individual Bankruptcy</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">Manage corporate bankruptcy proceedings with comprehensive asset tracking and creditor management.</p>
                        <div class="flex items-center text-orange-600 text-sm font-semibold group-hover:text-orange-700 transition-colors duration-300">
                            <span>Access Records</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>

                <!-- Admin Panel -->
                @if($user->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="group relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-500 transform hover:-translate-y-2 sm:col-span-2 lg:col-span-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative p-8">
                            <div class="flex items-center justify-between mb-6">
                                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                                    <i class="fas fa-cog text-white text-xl"></i>
                        </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-300">
                                        {{ \App\Models\User::where('role', 'admin')->count() }}
                    </div>
                                    <div class="text-xs text-gray-500 font-medium">Admin Users</div>
                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors duration-300">Admin Panel</h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4">Access system administration tools, user management, and advanced configuration options.</p>
                            <div class="flex items-center text-indigo-600 text-sm font-semibold group-hover:text-indigo-700 transition-colors duration-300">
                                <span>Access Panel</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </div>
                    </a>
                @endif
            </div>

            <!-- Enhanced Search Section -->
            <div class="bg-gradient-to-r from-accent-50 to-primary-50 rounded-xl border border-accent-200 p-8 mt-8 shadow-lg">
                <div class="flex items-center mb-6">
                    <div class="flex items-center justify-center w-12 h-12 bg-accent-100 rounded-full mr-4">
                        <i class="fas fa-search text-accent-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Quick Search</h3>
                        <p class="text-sm text-gray-600 mt-1">Find records across all databases instantly</p>
                    </div>
                </div>
                
                <form id="searchForm" class="space-y-6">
                        @csrf
                        <div>
                        <label for="search_input" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Search Records
                            </label>
                        <div class="relative w-full">
                            <input type="text" 
                                   id="search_input" 
                                   name="search_input" 
                                   class="w-full px-4 pr-12 py-4 border border-gray-300 rounded-lg text-base placeholder-gray-400 focus:border-accent-500 focus:ring-2 focus:ring-accent-100 focus:outline-none transition-all duration-300 bg-white" 
                                   placeholder="Enter IC number, company registration number, or name..."
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <button type="button" 
                                        id="clearSearchBtn" 
                                        class="text-gray-400 hover:text-gray-600 transition-all duration-200 p-1 rounded-full hover:bg-gray-100 cursor-pointer" 
                                        style="display: none;" 
                                        title="Clear search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-check-circle mr-2" style="color: #1e40af;"></i>
                                IC Numbers
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-user mr-2" style="color: #166534;"></i>
                                Names
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-building mr-2" style="color: #7c3aed;"></i>
                                Companies
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                <i class="fas fa-tag mr-2" style="color: #c2410c;"></i>
                                References
                            </span>
                        </div>
                        </div>
                        
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-8 py-4 text-base font-semibold rounded-xl text-white transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" style="background: linear-gradient(to right, #059669, #047857); border: none; outline: none;" onmouseover="this.style.background='linear-gradient(to right, #047857, #065f46)'" onmouseout="this.style.background='linear-gradient(to right, #059669, #047857)'">
                            <i class="fas fa-search mr-3" style="color: white;"></i>
                            Search Records
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Search Results -->
<div id="searchResults" class="hidden bg-white rounded-xl border border-gray-200 mt-8 shadow-lg overflow-hidden max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full mr-4">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Search Results</h3>
                    <p class="text-sm text-gray-600 mt-1">Matching records found</p>
                </div>
            </div>
            <button type="button" id="clearDashboardSearchResultsBtn" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5" style="background: linear-gradient(to right, #ef4444, #dc2626); border: none; outline: none;" onmouseover="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'" onmouseout="this.style.background='linear-gradient(to right, #ef4444, #dc2626)'">
                <i class="fas fa-times mr-2"></i>
                Clear Results
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider" style="width: 35%;">Name/Company</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider" style="width: 20%;">IC/Registration No</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider" style="width: 15%;">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider" style="width: 20%;">Release Type</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider" style="width: 10%;">Actions</th>
                </tr>
            </thead>
            <tbody id="searchResultsBody" class="bg-white divide-y divide-gray-200">
                <!-- Results will be populated here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Enhanced No Results -->
<div id="noResults" class="hidden bg-gradient-to-br from-white to-gray-50 rounded-2xl border-2 border-gray-200 p-16 mt-8 shadow-2xl max-w-7xl mx-auto">
    <div class="text-center max-w-2xl mx-auto">
        <!-- Animated Icon -->
        <div class="relative mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-red-100 to-pink-100 rounded-full mb-4 shadow-lg">
                <i class="fas fa-file-alt text-red-500 text-3xl animate-pulse"></i>
            </div>
            <!-- Decorative elements -->
            <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full animate-bounce"></div>
            <div class="absolute -bottom-2 -left-2 w-4 h-4 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
        </div>
        
        <!-- Main Message -->
        <h3 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">No Records Found</h3>
        <p class="text-xl text-gray-600 mb-8 leading-relaxed">We couldn't find any records matching your search criteria.</p>
        
        <!-- Enhanced Search Suggestions -->
        <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-2 border-blue-200 rounded-2xl p-8 shadow-lg">
            <div class="flex items-center justify-center mb-6">
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mr-3">
                    <i class="fas fa-info-circle text-blue-600 text-lg"></i>
                </div>
                <h4 class="text-2xl font-bold text-blue-900">Try searching with:</h4>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-blue-100">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full mr-4">
                        <i class="fas fa-check-circle text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-900">Different Keywords</div>
                        <div class="text-xs text-gray-500">Try alternative terms</div>
                    </div>
                </div>
                
                <div class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-blue-100">
                    <div class="flex items-center justify-center w-10 h-10 bg-purple-100 rounded-full mr-4">
                        <i class="fas fa-file-alt text-purple-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-900">Check for Typos</div>
                        <div class="text-xs text-gray-500">Verify names or numbers</div>
                    </div>
                </div>
                
                <div class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-blue-100">
                    <div class="flex items-center justify-center w-10 h-10 bg-orange-100 rounded-full mr-4">
                        <i class="fas fa-user text-orange-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-900">Partial Matches</div>
                        <div class="text-xs text-gray-500">Use "John" instead of "John Smith"</div>
                    </div>
                </div>
                
                <div class="flex items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-blue-100">
                    <div class="flex items-center justify-center w-10 h-10 bg-pink-100 rounded-full mr-4">
                        <i class="fas fa-tag text-pink-600 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-900">Different Formats</div>
                        <div class="text-xs text-gray-500">Try with or without dashes</div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Help -->
            <div class="mt-6 p-4 bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                    <span class="text-sm font-medium text-yellow-800">Tip: Try searching with fewer characters or different keywords</span>
                </div>
            </div>
        </div>
        
        <!-- Action Button -->
        <div class="mt-8">
            <button type="button" id="clearSearchFromNoResults" class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <i class="fas fa-redo mr-3"></i>
                Try Different Search
            </button>
        </div>
    </div>
</div>

<!-- Enhanced Loading Spinner -->
<div id="loadingSpinner" class="hidden bg-white rounded-xl border border-gray-200 p-12 mt-8 shadow-lg max-w-7xl mx-auto">
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-accent-100 to-primary-100 rounded-full mb-6">
            <i class="fas fa-spinner fa-spin text-accent-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Searching Records</h3>
        <p class="text-gray-600 mb-4">Please wait while we search for matching records...</p>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-gradient-to-r from-accent-500 to-primary-500 h-2 rounded-full animate-pulse" style="width: 60%"></div>
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
                    <i class="fas fa-times text-xl"></i>
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
            console.log('Clear dashboard search results button clicked');
            clearDashboardSearch();
        });
        console.log('Clear dashboard search results button event listener added');
    } else {
        console.error('Clear dashboard search results button not found');
    }

    // Clear search from no results button functionality
    const clearSearchFromNoResults = document.getElementById('clearSearchFromNoResults');
    if (clearSearchFromNoResults) {
        clearSearchFromNoResults.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Clear search from no results button clicked');
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
        console.log('Clear dashboard search function called');
        try {
            if (searchInput) {
                searchInput.value = '';
                clearSearchBtn.style.display = 'none';
            }
            searchResults.classList.add('hidden');
            noResults.classList.add('hidden');
            loadingSpinner.classList.add('hidden');
            console.log('Clear dashboard search completed successfully');
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
            row.className = 'hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-300 border-b border-gray-100';
            
            // Add alternating row colors
            if (index % 2 === 0) {
                row.classList.add('bg-white');
            } else {
                row.classList.add('bg-gray-50');
            }
            
            let identifier, name, type, releaseType, typeColor, typeBg;
            
            if (result.ic_no) {
                identifier = result.ic_no;
                name = result.name || 'N/A';
                type = result.record_type === 'annulment' ? 'Annulment' : 'Individual Bankruptcy';
                releaseType = result.release_type || 'N/A';
                
                if (type === 'Annulment') {
                    typeColor = 'text-green-800';
                    typeBg = 'bg-green-100';
                } else {
                    typeColor = 'text-red-800';
                    typeBg = 'bg-red-100';
                }
            } else if (result.company_registration_no) {
                identifier = result.company_registration_no;
                name = result.company_name || 'N/A';
                type = 'Non-Individual Bankruptcy';
                releaseType = 'N/A';
                typeColor = 'text-orange-800';
                typeBg = 'bg-orange-100';
            } else {
                identifier = 'N/A';
                name = 'N/A';
                type = 'Unknown';
                releaseType = 'N/A';
                typeColor = 'text-gray-800';
                typeBg = 'bg-gray-100';
            }
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                <span class="text-sm font-bold text-white">${(name || 'N/A').charAt(0).toUpperCase()}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-bold text-gray-900">${name}</div>
                            <div class="text-xs text-gray-500">${type} Record</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 bg-blue-50 px-3 py-1 rounded-lg inline-block">${identifier}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${typeBg} ${typeColor}">
                        ${type}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                        ${releaseType !== 'N/A' ? 
                            `<span class="bg-orange-50 text-orange-800 px-3 py-1 rounded-lg text-xs font-medium">${releaseType}</span>` : 
                            '<span class="text-gray-400">N/A</span>'
                        }
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="showDetails(${result.id}, '${result.table_name || ''}')" class="inline-flex items-center px-3 py-2 text-xs font-medium text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md" style="background: linear-gradient(to right, #3b82f6, #2563eb); border: none; outline: none;" onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'" onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'">
                        <i class="fas fa-eye mr-2"></i>
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
        searchResults.classList.add('hidden');
    }

    // Global function for showing details
    window.showDetails = function(id, tableName = '') {
        // Ensure modal is hidden first
        detailsModal.classList.add('hidden');
        
        // Build URL with table parameter if provided
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
        
        // Debug logging
        console.log('Record type detected:', recordType);
        console.log('Record data:', record);
        
        let modalContentHTML = '';
        
        if (recordType === 'non-individual-bankruptcy' || (record.company_name && record.company_registration_no)) {
            // Non-Individual Bankruptcy
            modalContentHTML = `
                <div class="space-y-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-blue-900 mb-4">Non-Individual Bankruptcy Details</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-blue-700 font-medium">Insolvency No:</span>
                                <span class="text-sm text-blue-900 font-medium">${record.insolvency_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-blue-700 font-medium">Company Name:</span>
                                <span class="text-sm text-blue-900 font-medium">${record.company_name || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-blue-700 font-medium">Company Registration No:</span>
                                <span class="text-sm text-blue-900 font-medium">${record.company_registration_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-blue-700 font-medium">Others:</span>
                                <span class="text-sm text-blue-900 font-medium">${record.others || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-blue-700 font-medium">Court Case No:</span>
                                <span class="text-sm text-blue-900 font-medium">${record.court_case_no || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-blue-700 font-medium">Date of Winding Up/Resolution:</span>
                                <span class="text-sm text-blue-900 font-medium">${record.date_of_winding_up_resolution ? new Date(record.date_of_winding_up_resolution).toLocaleDateString() : 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-blue-700 font-medium">Updated Date:</span>
                                <span class="text-sm text-blue-900 font-medium">${record.updated_date ? new Date(record.updated_date).toLocaleDateString() : 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-blue-700 font-medium">Branch:</span>
                                <span class="text-sm text-blue-900 font-medium">${record.branch || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (recordType === 'bankruptcy' || recordType === 'annulment' || record.ic_no) {
            // Individual records - show details based on actual record type
            if (recordType === 'bankruptcy' || record.insolvency_no || record.ro_date || record.ao_date) {
                // Show bankruptcy details only
                modalContentHTML = `
                    <div class="space-y-6">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-red-900 mb-4">Bankruptcy Details</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">Insolvency No:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.insolvency_no || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">Name:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.name || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">IC Number:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.ic_no || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">Others:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.others || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">Court Case No:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.court_case_no || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">Branch:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.branch || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">Status:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.is_active ? 'Active' : 'Inactive'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">RO Date:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.ro_date ? new Date(record.ro_date).toLocaleDateString() : 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">AO Date:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.ao_date ? new Date(record.ao_date).toLocaleDateString() : 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-red-700 font-medium">Updated Date:</span>
                                    <span class="text-sm text-red-900 font-medium">${record.updated_date || 'N/A'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else if (recordType === 'annulment' || record.release_date || record.release_type) {
                // Show annulment details only
                modalContentHTML = `
                    <div class="space-y-6">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-green-900 mb-4">Annulment Details</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-green-700 font-medium">Name:</span>
                                    <span class="text-sm text-green-900 font-medium">${record.name || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-green-700 font-medium">IC Number:</span>
                                    <span class="text-sm text-green-900 font-medium">${record.ic_no || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-green-700 font-medium">Others:</span>
                                    <span class="text-sm text-green-900 font-medium">${record.others || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-green-700 font-medium">Court Case No:</span>
                                    <span class="text-sm text-green-900 font-medium">${record.court_case_no || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-green-700 font-medium">Release Date:</span>
                                    <span class="text-sm text-green-900 font-medium">${record.release_date ? new Date(record.release_date).toLocaleDateString() : 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-green-700 font-medium">Updated Date:</span>
                                    <span class="text-sm text-green-900 font-medium">${record.updated_date || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-green-700 font-medium">Release Type:</span>
                                    <span class="text-sm text-green-900 font-medium">${record.release_type || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-green-700 font-medium">Branch:</span>
                                    <span class="text-sm text-green-900 font-medium">${record.branch || 'N/A'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Fallback - show basic details
                modalContentHTML = `
                    <div class="space-y-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Record Details</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-700 font-medium">Name:</span>
                                    <span class="text-sm text-gray-900 font-medium">${record.name || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-700 font-medium">IC Number:</span>
                                    <span class="text-sm text-gray-900 font-medium">${record.ic_no || 'N/A'}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-700 font-medium">Court Case No:</span>
                                    <span class="text-sm text-gray-900 font-medium">${record.court_case_no || 'N/A'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        } else {
            // Fallback for unknown types
            modalContentHTML = `
                <div class="space-y-4">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Record Details</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-700 font-medium">ID:</span>
                                <span class="text-sm text-gray-900 font-medium">${record.id || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-700 font-medium">Type:</span>
                                <span class="text-sm text-gray-900 font-medium">${recordType}</span>
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