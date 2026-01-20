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
            <!-- Total Individual Bankruptcy -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Individual Bankruptcy</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Bankruptcy::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user-x text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-gray-500">Active records</span>
                </div>
            </div>

            <!-- Total Non-Individual Bankruptcy -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Non-Individual Bankruptcy</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\NonIndividualBankruptcy::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-buildings text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-gray-500">Active records</span>
                </div>
            </div>

            <!-- Total Individual Annulment -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Individual Annulment</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\AnnulmentIndv::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user-check text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-gray-500">Active records</span>
                </div>
            </div>

            <!-- Total Non-Individual Annulment -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Non-Individual Annulment</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\AnnulmentNonIndv::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-building text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-gray-500">Active records</span>
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
                        <span>Search by IC number, company registration, insolvency number or court case number</span>
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
                                   placeholder="Enter IC number, company registration number, insolvency number or court case number..."
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
                                Company Registration Number
                            </span>
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <i class="bx bx-file-blank mr-1"></i>
                                Insolvency Numbers
                            </span>
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                                <i class="bx bx-file mr-1"></i>
                                Court Case Numbers
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <button type="button" id="bulkStatusUploadBtn" class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="bx bx-upload mr-2"></i>
                                Upload Excel
                            </button>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="bx bx-search mr-2"></i>
                            Search Records
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- File Upload Modal -->
        <div id="fileUploadModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-auto transform transition-all">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Upload Excel File for Status Check</h3>
                            <p class="text-sm text-gray-500 mt-1">Bulk status check for specific records</p>
                        </div>
                        <button type="button" id="closeFileUploadModal" class="text-gray-400 hover:text-gray-600">
                            <i class="bx bx-x text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Instructions Card -->
                <div class="px-6 py-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-blue-900">Upload Instructions</h3>
                                <div class="mt-2 text-sm text-blue-800">
                                    <p class="mb-2">Follow these steps to check status of records in bulk:</p>
                                    <ol class="list-decimal list-inside space-y-1">
                                        <li>Prepare an Excel file with the required columns</li>
                                        <li>Ensure all data follows the specified format</li>
                                        <li>Upload the Excel file to check record status</li>
                                        <li>Review the results for each record</li>
                                    </ol>
                                    <div class="mt-3 text-xs text-blue-700">
                                        <p><strong>Required columns:</strong> Name (Column A), IC/Registration Number (Column B)</p>
                                        <p><strong>Max file size:</strong> 10MB | <strong>Supported formats:</strong> .xlsx, .xls</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Form Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Upload Excel File</h3>
                            <p class="text-sm text-gray-500 mt-1">Select your Excel file to check record status</p>
                        </div>
                        
                        <form id="fileUploadForm" enctype="multipart/form-data" class="p-6">
                            @csrf
                            
                            <!-- File Upload -->
                            <div class="mb-6">
                                <label for="excelFile" class="block text-sm font-medium text-gray-700 mb-2">
                                    Excel File <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-orange-300 transition-colors duration-200" id="dropZone">
                                    <div class="space-y-1 text-center">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-4"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="excelFile" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                                <span>Upload a file</span>
                                                <input id="excelFile" name="excel_file" type="file" class="sr-only" accept=".xlsx,.xls" required>
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">Excel files only (XLSX, XLS) up to 10MB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- File Preview -->
                            <div id="file-preview" class="hidden mb-6">
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-excel text-green-600 text-xl mr-3"></i>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900" id="file-name"></p>
                                            <p class="text-xs text-gray-500" id="file-size"></p>
                                        </div>
                                        <button type="button" id="remove-file" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-between">
                                <div></div>
                                
                                <div class="flex items-center space-x-4">
                                    <button type="button" id="cancelFileUpload" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                                        Cancel
                                    </button>
                                    <button type="submit" id="submitFileUpload" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                                        <i class="fas fa-upload mr-2"></i>
                                        <span id="upload-text">Upload & Check Status</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Status Check Results -->
        <div id="bulkStatusResults" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="bx bx-check-circle text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Bulk Status Check Results</h3>
                            <p class="text-sm text-gray-500" id="bulkStatusDescription">Status check results from uploaded file</p>
                        </div>
                    </div>
                    <button type="button" id="clearBulkStatusResultsBtn" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-white transition-colors duration-200">
                        <i class="bx bx-x mr-2"></i>
                        Clear Results
                    </button>
                </div>
            </div>
            <div class="p-6">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Individual Bankruptcy Status -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-red-900">Individual Bankruptcy</h4>
                            <i class="bx bx-user-x text-red-600 text-lg"></i>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-red-700">Found:</span>
                                <span class="font-semibold text-red-900" id="individualBankruptcyFound">0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-red-700">Not Found:</span>
                                <span class="font-semibold text-red-900" id="individualBankruptcyNotFound">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Non-Individual Bankruptcy Status -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-red-900">Non-Individual Bankruptcy</h4>
                            <i class="bx bx-buildings text-red-600 text-lg"></i>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-red-700">Found:</span>
                                <span class="font-semibold text-red-900" id="nonIndividualBankruptcyFound">0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-red-700">Not Found:</span>
                                <span class="font-semibold text-red-900" id="nonIndividualBankruptcyNotFound">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Individual Annulment Status -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-green-900">Individual Annulment</h4>
                            <i class="bx bx-user-check text-green-600 text-lg"></i>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-green-700">Found:</span>
                                <span class="font-semibold text-green-900" id="individualAnnulmentFound">0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-green-700">Not Found:</span>
                                <span class="font-semibold text-green-900" id="individualAnnulmentNotFound">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Non-Individual Annulment Status -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-green-900">Non-Individual Annulment</h4>
                            <i class="bx bx-building text-green-600 text-lg"></i>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-green-700">Found:</span>
                                <span class="font-semibold text-green-900" id="nonIndividualAnnulmentFound">0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-green-700">Not Found:</span>
                                <span class="font-semibold text-green-900" id="nonIndividualAnnulmentNotFound">0</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Records Table -->
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Detailed Results</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name/Company</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC/Registration No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Record Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Insolvency No</th>
                                </tr>
                            </thead>
                            <tbody id="bulkStatusTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Records will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
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

<!-- Email Update Modal -->
<div id="emailUpdateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md mx-auto transform transition-all">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Update Email Address</h3>
                    <p class="text-sm text-gray-500 mt-1">Please update your email address. This is a one-time requirement.</p>
                </div>
                <button type="button" id="closeEmailUpdateModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1 rounded-lg hover:bg-gray-100">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Content -->
        <div class="p-6">
            <form id="emailUpdateForm">
                @csrf
                <div class="mb-6">
                    <label for="currentEmail" class="block text-sm font-medium text-gray-700 mb-2">
                        Current Email Address
                    </label>
                    <input type="email" 
                           id="currentEmail" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200" 
                           value="{{ auth()->user()->email }}" 
                           readonly>
                </div>
                
                <div class="mb-6">
                    <label for="newEmail" class="block text-sm font-medium text-gray-700 mb-2">
                        New Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="newEmail" 
                           name="email" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200" 
                           placeholder="Enter your new email address"
                           required>
                    <p class="mt-2 text-sm text-gray-500">
                        Please enter a valid email address
                    </p>
                </div>
                
                <div class="mb-6">
                    <label for="confirmEmail" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm New Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="confirmEmail" 
                           name="email_confirmation" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200" 
                           placeholder="Confirm your new email address"
                           required>
                </div>
                
                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4">
                    <button type="button" id="skipEmailUpdate" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                        Skip for Now
                    </button>
                    <button type="submit" id="updateEmailBtn" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="bx bx-check mr-2"></i>
                        Update Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" onclick="closeRecordDetails()">
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-4xl mx-auto transform transition-all" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Record Details</h3>
                    <p class="text-sm text-gray-500 mt-1">View detailed information about this record</p>
                </div>
                <button type="button" onclick="closeRecordDetails()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1 rounded-lg hover:bg-gray-100">
                    <i class="bx bx-x text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Content -->
        <div id="modalContent" class="p-6">
            <!-- Content will be loaded here -->
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
    const bulkStatusUploadBtn = document.getElementById('bulkStatusUploadBtn');
    const fileUploadModal = document.getElementById('fileUploadModal');
    const closeFileUploadModal = document.getElementById('closeFileUploadModal');
    const cancelFileUpload = document.getElementById('cancelFileUpload');
    const fileUploadForm = document.getElementById('fileUploadForm');
    const submitFileUpload = document.getElementById('submitFileUpload');
    const bulkStatusResults = document.getElementById('bulkStatusResults');
    const clearBulkStatusResultsBtn = document.getElementById('clearBulkStatusResultsBtn');
    const bulkStatusDescription = document.getElementById('bulkStatusDescription');
    const bulkStatusTableBody = document.getElementById('bulkStatusTableBody');
    
    // Email update modal elements
    const emailUpdateModal = document.getElementById('emailUpdateModal');
    const closeEmailUpdateModal = document.getElementById('closeEmailUpdateModal');
    const skipEmailUpdate = document.getElementById('skipEmailUpdate');
    const emailUpdateForm = document.getElementById('emailUpdateForm');
    const updateEmailBtn = document.getElementById('updateEmailBtn');
    const newEmailInput = document.getElementById('newEmail');
    const confirmEmailInput = document.getElementById('confirmEmail');
    
    // Debug: Check if elements exist
    console.log('bulkStatusResults element:', bulkStatusResults);
    console.log('bulkStatusTableBody element:', bulkStatusTableBody);

    // Show email update modal for admin users after login
    // Check if this is an admin user and needs email update
    @if(auth()->user()->isAdmin() && auth()->user()->needsEmailUpdate())
        // Show email update modal after a short delay to ensure page is loaded
        setTimeout(function() {
            emailUpdateModal.classList.remove('hidden');
        }, 1000);
    @endif

    // Email update modal functionality
    if (closeEmailUpdateModal) {
        closeEmailUpdateModal.addEventListener('click', function() {
            emailUpdateModal.classList.add('hidden');
        });
    }

    if (skipEmailUpdate) {
        skipEmailUpdate.addEventListener('click', function() {
            emailUpdateModal.classList.add('hidden');
        });
    }

    // Email validation
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Handle email update form submission
    if (emailUpdateForm) {
        emailUpdateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newEmail = newEmailInput.value.trim();
            const confirmEmail = confirmEmailInput.value.trim();
            
            // Validate email fields
            if (!newEmail) {
                Swal.fire({
                    title: 'Email Required',
                    text: 'Please enter a new email address.',
                    icon: 'warning',
                    confirmButtonColor: '#f59e0b',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            if (!validateEmail(newEmail)) {
                Swal.fire({
                    title: 'Invalid Email',
                    text: 'Please enter a valid email address.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            if (newEmail !== confirmEmail) {
                Swal.fire({
                    title: 'Email Mismatch',
                    text: 'The email addresses do not match. Please check and try again.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Check if new email is different from current email
            const currentEmail = document.getElementById('currentEmail').value;
            if (newEmail === currentEmail) {
                Swal.fire({
                    title: 'Same Email',
                    text: 'The new email address is the same as your current email address.',
                    icon: 'info',
                    confirmButtonColor: '#3b82f6',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Show loading state
            updateEmailBtn.disabled = true;
            updateEmailBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i>Updating...';
            
            // Submit the form
            const formData = new FormData(emailUpdateForm);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch('{{ route("admin.update-email") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Email Updated!',
                        text: data.message || 'Your email address has been updated successfully. You will not be prompted to update it again.',
                        icon: 'success',
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        emailUpdateModal.classList.add('hidden');
                        // Update the current email display
                        document.getElementById('currentEmail').value = newEmail;
                        // Clear the form
                        emailUpdateForm.reset();
                    });
                } else {
                    Swal.fire({
                        title: 'Update Failed',
                        text: data.message || 'Failed to update email address. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while updating your email address.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            })
            .finally(() => {
                // Reset button state
                updateEmailBtn.disabled = false;
                updateEmailBtn.innerHTML = '<i class="bx bx-check mr-2"></i>Update Email';
            });
        });
    }

    // Handle file upload button
    if (bulkStatusUploadBtn) {
        bulkStatusUploadBtn.addEventListener('click', function() {
            fileUploadModal.classList.remove('hidden');
        });
    }

    // Clear bulk status results
    if (clearBulkStatusResultsBtn) {
        clearBulkStatusResultsBtn.addEventListener('click', function() {
            bulkStatusResults.classList.add('hidden');
        });
    }

    // Close file upload modal
    if (closeFileUploadModal) {
        closeFileUploadModal.addEventListener('click', function() {
            fileUploadModal.classList.add('hidden');
        });
    }

    if (cancelFileUpload) {
        cancelFileUpload.addEventListener('click', function() {
            fileUploadModal.classList.add('hidden');
        });
    }

    // Handle file upload form submission
    if (fileUploadForm) {
        fileUploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (excelFileInput.files.length === 0) {
                Swal.fire({
                    title: 'No File Selected',
                    text: 'Please select an Excel file to upload.',
                    icon: 'warning',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            performBulkStatusCheckFromFile();
        });
    }

    // File upload functionality (matching individual bankruptcy bulk upload)
    const excelFileInput = document.getElementById('excelFile');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFileBtn = document.getElementById('remove-file');
    const uploadText = document.getElementById('upload-text');
    const dropZone = document.getElementById('dropZone');
    
    if (excelFileInput) {
        // Handle file selection
        excelFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                showFilePreview(file);
            }
        });
        
        // Handle remove file
        if (removeFileBtn) {
            removeFileBtn.addEventListener('click', function() {
                excelFileInput.value = '';
                hideFilePreview();
            });
        }
        
        // Handle drag and drop
        if (dropZone) {
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropZone.classList.add('border-orange-400', 'bg-orange-50');
            });
            
            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                dropZone.classList.remove('border-orange-400', 'bg-orange-50');
            });
            
            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                dropZone.classList.remove('border-orange-400', 'bg-orange-50');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    excelFileInput.files = files;
                    excelFileInput.dispatchEvent(new Event('change'));
                }
            });
        }
    }
    
    function showFilePreview(file) {
        const fileNameText = file.name;
        const fileSizeText = formatFileSize(file.size);
        
        fileName.textContent = fileNameText;
        fileSize.textContent = fileSizeText;
        
        filePreview.classList.remove('hidden');
        dropZone.classList.add('hidden');
    }
    
    function hideFilePreview() {
        filePreview.classList.add('hidden');
        dropZone.classList.remove('hidden');
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function performBulkStatusCheckFromFile() {
        const fileInput = document.getElementById('excelFile');
        const file = fileInput.files[0];
        
        if (!file) {
            Swal.fire({
                title: 'Error',
                text: 'Please select an Excel file',
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Show loading state
        submitFileUpload.disabled = true;
        uploadText.textContent = 'Processing...';
        submitFileUpload.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        
        // Hide other results
        searchResults.classList.add('hidden');
        noResults.classList.add('hidden');
        loadingSpinner.classList.add('hidden');

        // Create FormData
        const formData = new FormData();
        formData.append('excel_file', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        // Upload file and check status
        fetch('{{ route("admin.bulk-status-file") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response data:', data); // Debug log
            if (data.success) {
                // Display the results
                console.log('Displaying results...'); // Debug log
                displayBulkStatusResults(data.data);
                
                // Reset file input
                excelFileInput.value = '';
                hideFilePreview();
                fileUploadModal.classList.add('hidden');
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Failed to process Excel file',
                    icon: 'error',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'An error occurred while processing the file',
                icon: 'error',
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'OK'
            });
        })
        .finally(() => {
            // Reset button state
            submitFileUpload.disabled = false;
            uploadText.textContent = 'Upload & Check Status';
            submitFileUpload.innerHTML = '<i class="fas fa-upload mr-2"></i>Upload & Check Status';
        });
    }

    function displayBulkStatusResults(data) {
        console.log('displayBulkStatusResults called with data:', data); // Debug log
        
        // Check if required elements exist
        if (!bulkStatusResults) {
            console.error('bulkStatusResults element not found');
            return;
        }
        
        if (!data || !data.records) {
            console.error('Invalid data structure:', data);
            return;
        }
        
        console.log('Records to display:', data.records.length); // Debug log
        
        // Update summary cards
        updateSummaryCards(data.records);
        
        // Display detailed records table
        displayRecordsTable(data.records);
        
        // Show results section
        bulkStatusResults.classList.remove('hidden');
        bulkStatusDescription.textContent = `Status check for ${data.records.length} records from uploaded file`;
        
        console.log('Results section should now be visible'); // Debug log
    }

    function updateSummaryCards(records) {
        // Count records by type and status
        const counts = {
            individual_bankruptcy: { found: 0, notFound: 0 },
            non_individual_bankruptcy: { found: 0, notFound: 0 },
            individual_annulment: { found: 0, notFound: 0 },
            non_individual_annulment: { found: 0, notFound: 0 }
        };

        records.forEach(record => {
            if (record.record_type) {
                const type = record.record_type.toLowerCase().replace(/\s+/g, '_');
                if (counts[type]) {
                    if (record.found) {
                        counts[type].found++;
                    } else {
                        counts[type].notFound++;
                    }
                }
            }
        });

        // Update Individual Bankruptcy
        document.getElementById('individualBankruptcyFound').textContent = counts.individual_bankruptcy.found;
        document.getElementById('individualBankruptcyNotFound').textContent = counts.individual_bankruptcy.notFound;

        // Update Non-Individual Bankruptcy
        document.getElementById('nonIndividualBankruptcyFound').textContent = counts.non_individual_bankruptcy.found;
        document.getElementById('nonIndividualBankruptcyNotFound').textContent = counts.non_individual_bankruptcy.notFound;

        // Update Individual Annulment
        document.getElementById('individualAnnulmentFound').textContent = counts.individual_annulment.found;
        document.getElementById('individualAnnulmentNotFound').textContent = counts.individual_annulment.notFound;

        // Update Non-Individual Annulment
        document.getElementById('nonIndividualAnnulmentFound').textContent = counts.non_individual_annulment.found;
        document.getElementById('nonIndividualAnnulmentNotFound').textContent = counts.non_individual_annulment.notFound;
    }

    function displayRecordsTable(records) {
        console.log('displayRecordsTable called with records:', records); // Debug log
        
        const tbody = bulkStatusTableBody;
        if (!tbody) {
            console.error('bulkStatusTableBody element not found');
            return;
        }
        
        tbody.innerHTML = '';
        console.log('Cleared table body, adding records...'); // Debug log

        records.forEach((record, index) => {
            const row = document.createElement('tr');
            row.className = `hover:bg-gray-50 transition-colors duration-200 ${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'}`;
            
            const statusBadge = record.found ? 
                (record.is_active ? 
                    '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✓ Active</span>' :
                    '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">✗ Inactive</span>'
                ) : 
                '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">? Not Found</span>';

            const recordType = record.record_type || 'N/A';
            const insolvencyNo = record.insolvency_no || 'N/A';
            const name = record.name || record.company_name || 'N/A';
            const identifier = record.ic_no || record.company_registration_no || 'N/A';

            // Add record type styling
            let recordTypeBadge = '';
            if (record.record_type) {
                const typeColors = {
                    'Individual Bankruptcy': 'bg-red-100 text-red-800 border-red-200',
                    'Non-Individual Bankruptcy': 'bg-orange-100 text-orange-800 border-orange-200',
                    'Individual Annulment': 'bg-green-100 text-green-800 border-green-200',
                    'Non-Individual Annulment': 'bg-blue-100 text-blue-800 border-blue-200'
                };
                const colorClass = typeColors[record.record_type] || 'bg-gray-100 text-gray-800 border-gray-200';
                recordTypeBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ${colorClass}">${recordType}</span>`;
            } else {
                recordTypeBadge = '<span class="text-sm text-gray-500">N/A</span>';
            }

            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-semibold text-gray-900">${name}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-mono text-gray-700 bg-gray-100 px-2 py-1 rounded">${identifier}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${recordTypeBadge}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${statusBadge}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-mono text-gray-700 bg-gray-100 px-2 py-1 rounded">${insolvencyNo}</div>
                </td>
            `;
            
            tbody.appendChild(row);
        });
        
        console.log(`Added ${records.length} rows to the table`); // Debug log
    }

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
            
            console.log('Bankruptcy search results:', bankruptcyData);
            console.log('Annulment search results:', annulmentData);
            
            // Combine results from both searches
            let allResults = [];
            
            if (bankruptcyData.success && bankruptcyData.results) {
                allResults = allResults.concat(bankruptcyData.results);
            }
            
            if (annulmentData.success && annulmentData.results) {
                allResults = allResults.concat(annulmentData.results);
            }
            
            console.log('Combined results before deduplication:', allResults);
            
            // Remove duplicates based on IC number, company registration number, or insolvency number
            const uniqueResults = [];
            const seenIdentifiers = new Set();
            
            allResults.forEach(result => {
                const identifier = result.ic_no || result.company_registration_no || result.insolvency_no;
                if (identifier && !seenIdentifiers.has(identifier)) {
                    seenIdentifiers.add(identifier);
                    uniqueResults.push(result);
                }
            });
            
            console.log('Unique results after deduplication:', uniqueResults);
            
            if (uniqueResults.length > 0) {
                displayResults(uniqueResults);
            } else {
                showNoResults(data.message || 'No records found for your search criteria.');
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
                type = result.record_type === 'non-individual-annulment' ? 'Non-Individual Annulment' : 'Non-Individual Bankruptcy';
                releaseType = result.release_type || 'N/A';
                
                if (type === 'Non-Individual Annulment') {
                    typeColor = 'text-green-700';
                    typeBg = 'bg-green-100';
                } else {
                    typeColor = 'text-gray-700';
                    typeBg = 'bg-gray-100';
                }
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

    function showNoResults(message = 'No records found for your search criteria.') {
        // Update the no results message
        const noResultsText = noResults.querySelector('p');
        if (noResultsText) {
            noResultsText.textContent = message;
        }
        
        noResults.classList.remove('hidden');
        searchResults.classList.add('hidden');
    }

    // Function to update modal header with record information
    function updateModalHeader(record) {
        const modalHeader = document.querySelector('#detailsModal .px-6.py-4.border-b.border-gray-200 h3');
        const modalSubtext = document.querySelector('#detailsModal .px-6.py-4.border-b.border-gray-200 p');
        
        if (modalHeader && modalSubtext) {
            const recordType = record.record_type || 'Unknown';
            const recordId = record.id || 'N/A';
            
            // Format record type for display
            let displayType = recordType;
            switch (recordType) {
                case 'bankruptcy':
                    displayType = 'Bankruptcy Record Details';
                    break;
                case 'non-individual-bankruptcy':
                    displayType = 'Non-Individual Bankruptcy Record Details';
                    break;
                case 'annulment':
                    displayType = 'Individual Annulment Record Details';
                    break;
                case 'non-individual-annulment':
                    displayType = 'Non-Individual Annulment Record Details';
                    break;
                default:
                    displayType = `${recordType.charAt(0).toUpperCase() + recordType.slice(1)} Record Details`;
            }
            
            modalHeader.textContent = displayType;
            modalSubtext.textContent = 'View detailed information about this record';
        }
    }

    // Function to reset modal header to default
    function resetModalHeader() {
        const modalHeader = document.querySelector('#detailsModal .px-6.py-4.border-b.border-gray-200 h3');
        const modalSubtext = document.querySelector('#detailsModal .px-6.py-4.border-b.border-gray-200 p');
        
        if (modalHeader && modalSubtext) {
            modalHeader.textContent = 'Record Details';
            modalSubtext.textContent = 'View detailed information about this record';
        }
    }

    // Function to generate HTML for record details
    function generateRecordDetailsHTML(record) {
        console.log('Generating HTML for record:', record); // Debug log
        
        const recordType = record.record_type || 'Unknown';
        const name = record.name || record.company_name || 'N/A';
        const identifier = record.ic_no || record.company_registration_no || 'N/A';
        const insolvencyNo = record.insolvency_no || 'N/A';
        const courtCaseNo = record.court_case_no || 'N/A';
        const releaseType = record.release_type || 'N/A';
        const branch = record.branch || 'N/A';
        const others = record.others || 'N/A';
        
        // Format dates
        const formatDate = (date) => {
            if (!date || date === null || date === undefined || date === '') return 'N/A';
            
            // Handle different date formats
            let dateObj;
            try {
                // Try to parse the date
                dateObj = new Date(date);
                
                // Check if the date is valid
                if (isNaN(dateObj.getTime())) {
                    return 'N/A';
                }
                
                // Return formatted date
                return dateObj.toLocaleDateString('en-GB');
            } catch (e) {
                console.warn('Date formatting error:', e, 'for date:', date);
                return 'N/A';
            }
        };
        
        const releaseDate = formatDate(record.release_date);
        const updatedDate = formatDate(record.updated_date);
        const createdAt = formatDate(record.created_at);
        const windingUpDate = formatDate(record.date_of_winding_up_resolution);
        const roDate = formatDate(record.ro_date);
        const aoDate = formatDate(record.ao_date);
        
        // Determine background color based on record type
        let backgroundColor = 'bg-white';
        let borderColor = 'border-gray-200';
        let textColor = 'text-gray-900';
        
        if (recordType === 'bankruptcy' || recordType === 'non-individual-bankruptcy') {
            backgroundColor = 'bg-red-50';
            borderColor = 'border-red-200';
            textColor = 'text-red-900';
        } else if (recordType === 'annulment' || recordType === 'non-individual-annulment') {
            backgroundColor = 'bg-green-50';
            borderColor = 'border-green-200';
            textColor = 'text-green-900';
        }
        
        return `
            <div class="space-y-6 ${backgroundColor} ${borderColor} border rounded-lg p-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium ${textColor} mb-3">Basic Information</h4>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-xs text-gray-500">Name/Company</dt>
                                <dd class="text-sm text-gray-900">${name}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">IC/Registration Number</dt>
                                <dd class="text-sm text-gray-900 font-mono">${identifier}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Insolvency Number</dt>
                                <dd class="text-sm text-gray-900 font-mono">${insolvencyNo}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Court Case Number</dt>
                                <dd class="text-sm text-gray-900">${courtCaseNo}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium ${textColor} mb-3">Additional Information</h4>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-xs text-gray-500">Release Type</dt>
                                <dd class="text-sm text-gray-900">${releaseType}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Branch</dt>
                                <dd class="text-sm text-gray-900">${branch}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Others</dt>
                                <dd class="text-sm text-gray-900">${others}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Status</dt>
                                <dd class="text-sm">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${record.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                        ${record.is_active ? 'Active' : 'Inactive'}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                
                <!-- Dates -->
                <div>
                    <h4 class="text-sm font-medium ${textColor} mb-3">Important Dates</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-xs text-gray-500">Release Date</dt>
                            <dd class="text-sm text-gray-900">${releaseDate}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500">Date of Winding Up/Resolution</dt>
                            <dd class="text-sm text-gray-900">${windingUpDate}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500">RO Date</dt>
                            <dd class="text-sm text-gray-900">${roDate}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500">AO Date</dt>
                            <dd class="text-sm text-gray-900">${aoDate}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500">Updated Date</dt>
                            <dd class="text-sm text-gray-900">${updatedDate}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500">Created Date</dt>
                            <dd class="text-sm text-gray-900">${createdAt}</dd>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <!-- Print Button -->
                        <button onclick="printRecordDetails()" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="bx bx-printer mr-2"></i>
                            Print Record
                        </button>
                        
                        <!-- Download Button -->
                        <button onclick="downloadRecordDetails()" class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="bx bx-download mr-2"></i>
                            Download PDF
                        </button>
                        
                        <!-- Close Button -->
                        <button onclick="closeRecordDetails()" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="bx bx-x mr-2"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // Global function for showing details
    window.showDetails = function(id, tableName = '') {
        console.log('showDetails called with ID:', id, 'Table:', tableName); // Debug log
        
        const detailsModal = document.getElementById('detailsModal');
        const modalContent = document.getElementById('modalContent');
        
        if (detailsModal) {
            // Check if ID is valid
            if (!id || id === 'unknown' || id === 'undefined') {
                modalContent.innerHTML = `
                    <div class="p-8 text-center">
                        <i class="bx bx-error text-red-500 text-4xl mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Invalid Record</h3>
                        <p class="text-gray-600">This record cannot be viewed. The record ID is missing or invalid.</p>
                    </div>
                `;
                detailsModal.classList.remove('hidden');
                return;
            }
            
            // Show loading state
            modalContent.innerHTML = `
                <div class="flex items-center justify-center p-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div>
                    <span class="ml-3 text-gray-600">Loading record details...</span>
                </div>
            `;
            
            detailsModal.classList.remove('hidden');
            
            // Fetch details
            fetch(`/search/details/${id}?table=${tableName}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Details response:', data); // Debug log
                    if (data.success && data.record) {
                        // Update modal header with record information
                        updateModalHeader(data.record);
                        
                        // Generate HTML from the record data
                        const record = data.record;
                        modalContent.innerHTML = generateRecordDetailsHTML(record);
                    } else {
                        // Reset modal header for error
                        resetModalHeader();
                        modalContent.innerHTML = `
                            <div class="p-8 text-center">
                                <i class="bx bx-error text-red-500 text-4xl mb-4"></i>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Error</h3>
                                <p class="text-gray-600">${data.message || 'Failed to load details'}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset modal header for error
                    resetModalHeader();
                    modalContent.innerHTML = `
                        <div class="p-8 text-center">
                            <i class="bx bx-error text-red-500 text-4xl mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Error</h3>
                            <p class="text-gray-600">An error occurred while loading details</p>
                        </div>
                    `;
                });
        }
    };

    // Global functions for record details actions
    window.printRecordDetails = function() {
        const modalContent = document.getElementById('modalContent');
        if (modalContent) {
            // Create a new window for printing
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Record Details - Print Version</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .print-header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                        .print-header h2 { margin: 0; color: #333; }
                        .print-header p { margin: 5px 0 0 0; color: #666; font-size: 14px; }
                        .space-y-6 > * + * { margin-top: 1.5rem; }
                        .grid { display: grid; }
                        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
                        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                        .gap-4 { gap: 1rem; }
                        .gap-6 { gap: 1.5rem; }
                        .space-y-2 > * + * { margin-top: 0.5rem; }
                        .space-y-6 > * + * { margin-top: 1.5rem; }
                        .text-sm { font-size: 0.875rem; }
                        .text-xs { font-size: 0.75rem; }
                        .font-medium { font-weight: 500; }
                        .text-gray-700 { color: #374151; }
                        .text-gray-500 { color: #6b7280; }
                        .text-gray-900 { color: #111827; }
                        .font-mono { font-family: ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace; }
                        .border-t { border-top-width: 1px; }
                        .border-gray-200 { border-color: #e5e7eb; }
                        .pt-6 { padding-top: 1.5rem; }
                        .mb-3 { margin-bottom: 0.75rem; }
                        .mb-4 { margin-bottom: 1rem; }
                        .flex { display: flex; }
                        .items-center { align-items: center; }
                        .justify-center { justify-content: center; }
                        .gap-3 { gap: 0.75rem; }
                        .flex-wrap { flex-wrap: wrap; }
                        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
                        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
                        .rounded-full { border-radius: 9999px; }
                        .text-xs { font-size: 0.75rem; }
                        .font-medium { font-weight: 500; }
                        .bg-green-100 { background-color: #dcfce7; }
                        .text-green-800 { color: #166534; }
                        .bg-red-100 { background-color: #fee2e2; }
                        .text-red-800 { color: #991b1b; }
                        .inline-flex { display: inline-flex; }
                        @media print {
                            body { margin: 0; }
                            .print-header { page-break-after: avoid; }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-header">
                        <h2>Record Details - Print Version</h2>
                        <p>Generated on: ${new Date().toLocaleString()}</p>
                    </div>
                    ${modalContent.innerHTML}
                </body>
            </html>
            `);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
    };

    window.downloadRecordDetails = function() {
        const modalContent = document.getElementById('modalContent');
        if (modalContent) {
            // For now, we'll use a simple approach - in a real app, you'd want to use a PDF library
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Record Details - PDF Export</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .print-header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                        .print-header h2 { margin: 0; color: #333; }
                        .print-header p { margin: 5px 0 0 0; color: #666; font-size: 14px; }
                        .space-y-6 > * + * { margin-top: 1.5rem; }
                        .grid { display: grid; }
                        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
                        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                        .gap-4 { gap: 1rem; }
                        .gap-6 { gap: 1.5rem; }
                        .space-y-2 > * + * { margin-top: 0.5rem; }
                        .space-y-6 > * + * { margin-top: 1.5rem; }
                        .text-sm { font-size: 0.875rem; }
                        .text-xs { font-size: 0.75rem; }
                        .font-medium { font-weight: 500; }
                        .text-gray-700 { color: #374151; }
                        .text-gray-500 { color: #6b7280; }
                        .text-gray-900 { color: #111827; }
                        .font-mono { font-family: ui-monospace, SFMono-Regular, "SF Mono", Consolas, "Liberation Mono", Menlo, monospace; }
                        .border-t { border-top-width: 1px; }
                        .border-gray-200 { border-color: #e5e7eb; }
                        .pt-6 { padding-top: 1.5rem; }
                        .mb-3 { margin-bottom: 0.75rem; }
                        .mb-4 { margin-bottom: 1rem; }
                        .flex { display: flex; }
                        .items-center { align-items: center; }
                        .justify-center { justify-content: center; }
                        .gap-3 { gap: 0.75rem; }
                        .flex-wrap { flex-wrap: wrap; }
                        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
                        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
                        .rounded-full { border-radius: 9999px; }
                        .text-xs { font-size: 0.75rem; }
                        .font-medium { font-weight: 500; }
                        .bg-green-100 { background-color: #dcfce7; }
                        .text-green-800 { color: #166534; }
                        .bg-red-100 { background-color: #fee2e2; }
                        .text-red-800 { color: #991b1b; }
                        .inline-flex { display: inline-flex; }
                        @media print {
                            body { margin: 0; }
                            .print-header { page-break-after: avoid; }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-header">
                        <h2>Record Details - PDF Export</h2>
                        <p>Generated on: ${new Date().toLocaleString()}</p>
                    </div>
                    ${modalContent.innerHTML}
                </body>
            </html>
            `);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
    };

    window.closeRecordDetails = function() {
        const detailsModal = document.getElementById('detailsModal');
        if (detailsModal) {
            detailsModal.classList.add('hidden');
        }
    };


    // Modal functionality - now handled by global functions
    const detailsModal = document.getElementById('detailsModal');

    // Initialize modal as hidden
    if (detailsModal) {
        detailsModal.classList.add('hidden');
    }
});
</script>

@endsection


