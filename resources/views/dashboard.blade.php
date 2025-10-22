@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $user->name }}</h1>
                    <p class="text-gray-600 mt-1">Here's what's happening with your insolvency information system today.</p>
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
            <!-- Bankruptcy Individual Records -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Bankruptcy Individual Records</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Bankruptcy::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user-x text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+5%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Bankruptcy Company Records -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Bankruptcy Company Records</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\NonIndividualBankruptcy::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-buildings text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+3%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Annulment Individual Records -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Annulment Individual Records</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\AnnulmentIndv::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user-check text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+8%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Annulment Company Records -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Annulment Company Records</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\AnnulmentNonIndv::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-building text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+6%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Quick Actions</h2>
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

                    @if($user->hasAdminPrivileges() || $user->isIdManagement())
                    <!-- User Management -->
                    <a href="{{ route('user-management.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-blue-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-100 transition-colors duration-200">
                            <i class="bx bx-group text-blue-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">User Management</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage system users and permissions</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\User::count() }} total users</div>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors duration-200"></i>
                    </a>
                    @endif

                    @if($user->isIdManagement())
                    <!-- ID Management Dashboard -->
                    <a href="{{ route('id-management.dashboard') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-purple-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-purple-100 transition-colors duration-200">
                            <i class="bx bx-id-card text-purple-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">ID Management</h3>
                            <p class="text-xs text-gray-500 mt-1">Manage ID verification and validation</p>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors duration-200"></i>
                    </a>
                    @endif

                    @if($user->isSuperUser())
                    <!-- Audit Logs -->
                    <a href="{{ route('audit-logs.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-orange-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-100 transition-colors duration-200">
                            <i class="bx bx-clipboard text-orange-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">Audit Logs</h3>
                            <p class="text-xs text-gray-500 mt-1">View system activity and changes</p>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-orange-600 transition-colors duration-200"></i>
                    </a>
                    @endif
                </div>
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
    // Basic modal functionality for any future modals
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