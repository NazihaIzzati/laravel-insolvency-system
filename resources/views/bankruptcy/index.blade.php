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
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('bankruptcy.create') }}" class="professional-button-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Record
                    </a>
                    <a href="{{ route('bankruptcy.bulk-upload') }}" class="professional-button">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Bulk Upload
                    </a>
                    @if($bankruptcies->count() > 0)
                        <a href="{{ route('bankruptcy.download') }}" class="professional-button">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Excel
                        </a>
                    @endif
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
                @if($bankruptcies->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-primary-200">
                            <thead class="bg-primary-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Insolvency No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">IC No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Court Case</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">RO Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Branch</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Actions</th>
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
                                            <span class="text-sm text-primary-900">{{ $bankruptcy->branch ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('bankruptcy.show', $bankruptcy) }}" class="text-accent-600 hover:text-accent-700 transition-colors duration-200">View</a>
                                                <a href="{{ route('bankruptcy.edit', $bankruptcy) }}" class="text-green-600 hover:text-green-700 transition-colors duration-200">Edit</a>
                                                <form method="POST" action="{{ route('bankruptcy.destroy', $bankruptcy) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this bankruptcy record?')">
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
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                                </svg>
                                Add New Record
                            </a>
                        </div>
                    </div>
                @endif
        </div>
    </div>
</div>
@endsection
