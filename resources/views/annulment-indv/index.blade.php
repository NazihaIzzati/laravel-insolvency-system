@extends('layouts.app')

@section('content')
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .printable-area, .printable-area * {
        visibility: visible;
    }
    .printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
    .print-header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
    }
    .print-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    .print-table th,
    .print-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    .print-table th {
        background-color: #f0f0f0;
        font-weight: bold;
    }
    .print-summary {
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
    }
}
</style>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Printable Area -->
                <div class="printable-area">
                    <!-- Print Header -->
                    <div class="print-header">
                        <h1 class="text-3xl font-bold text-gray-900">ANNULMENT INDIVIDUAL MANAGEMENT REPORT</h1>
                        <p class="text-lg text-gray-600 mt-2">Insolvency Data System</p>
                        <p class="text-sm text-gray-500 mt-1">Generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <!-- Screen Header -->
                    <div class="no-print">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Annulment Individual Management</h2>
                                <p class="text-gray-600 mt-1">Manage annulment individual profiles and information</p>
                            </div>
                            <div class="flex space-x-3">
                                <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Print Report
                                </button>
                                <a href="{{ route('annulment-indv.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                    Add New Annulment Individual
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 no-print">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Annulment Individual Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 print-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-print">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    NO INVOLVENCY
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    NAME
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    IC NO
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    IC NO 2
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    COURT CASE NUMBER
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    RO DATE
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    AO DATE
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    UPDATED DATE
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    BRANCH NAME
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-print">
                                    ACTIONS
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($annulmentIndv as $member)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap no-print">
                                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-blue-600">{{ $member->no_involvency ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $member->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $member->ic_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $member->ic_no_2 ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $member->court_case_number ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $member->ro_date ? $member->ro_date->format('d/m/Y') : 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $member->ao_date ? $member->ao_date->format('d/m/Y') : 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $member->updated_date ? $member->updated_date->format('d/m/Y') : 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $member->branch_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium no-print">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('annulment-indv.show', $member) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('annulment-indv.edit', $member) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                            <form method="POST" action="{{ route('annulment-indv.destroy', $member) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this annulment individual?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-6 py-4 text-center text-gray-500">
                                        No annulment individuals found. <a href="{{ route('annulment-indv.create') }}" class="text-blue-600 hover:text-blue-800">Add the first annulment individual</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                    <!-- Footer -->
                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            {{ $annulmentIndv->count() }} annulment individual profile{{ $annulmentIndv->count() !== 1 ? 's' : '' }}
                        </div>
                    </div>

                    <!-- Print Summary -->
                    <div class="print-summary">
                        <p><strong>Total Records:</strong> {{ $annulmentIndv->count() }} annulment individual profile{{ $annulmentIndv->count() !== 1 ? 's' : '' }}</p>
                        <p><strong>Report Generated:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
