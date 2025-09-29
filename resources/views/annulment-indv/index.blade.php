@extends('layouts.app')

@section('title', 'Annulment Records')

@section('content')
<div class="min-h-screen bg-primary-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary-900 to-accent-600 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-12">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-4xl font-light mb-3">Annulment Records</h1>
                        <p class="text-xl text-primary-100 mb-2">Manage annulment individual profiles</p>
                        <p class="text-primary-200">Track and manage all annulment cases</p>
                    </div>
                    <div class="text-right text-white">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-6 py-4">
                            <p class="text-sm text-primary-100 mb-1">Total Records</p>
                            <p class="text-lg font-medium">{{ $annulmentIndv->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="professional-section mb-6">
            <div class="professional-section-content">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('annulment-indv.create') }}" class="professional-button-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Record
                    </a>
                    <button onclick="window.print()" class="professional-button">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="professional-section mb-6">
                <div class="professional-section-content">
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Records Table -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-primary-900">Annulment Records</h3>
                <p class="text-sm text-primary-500 mt-1">All annulment individual profiles</p>
            </div>
            <div class="professional-section-content">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-primary-200">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">
                                    No Involvency
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">
                                    IC No
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">
                                    Court Case
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">
                                    RO Date
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">
                                    Branch
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-primary-200">
                            @forelse($annulmentIndv as $member)
                                <tr class="hover:bg-primary-50 transition-colors duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm font-medium text-accent-600">{{ $member->no_involvency ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $member->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-600">{{ $member->ic_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $member->court_case_number ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $member->ro_date ? $member->ro_date->format('d/m/Y') : 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $member->branch_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('annulment-indv.show', $member) }}" class="text-accent-600 hover:text-accent-700 transition-colors duration-200">View</a>
                                            <a href="{{ route('annulment-indv.edit', $member) }}" class="text-green-600 hover:text-green-700 transition-colors duration-200">Edit</a>
                                            <form method="POST" action="{{ route('annulment-indv.destroy', $member) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this annulment individual?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700 transition-colors duration-200">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-primary-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="mx-auto h-12 w-12 text-primary-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="text-sm font-medium">No annulment records found</p>
                                            <p class="text-xs text-primary-400 mt-1">
                                                <a href="{{ route('annulment-indv.create') }}" class="text-accent-600 hover:text-accent-700">Add the first record</a>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
