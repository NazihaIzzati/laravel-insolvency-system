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
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('annulment-indv.create') }}" class="professional-button-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Record
                        </a>
                        <a href="{{ route('annulment-indv.bulk-upload') }}" class="professional-button-accent">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Bulk Upload
                        </a>
                        @if($annulmentIndv->count() > 0)
                            <a href="{{ route('annulment-indv.download') }}" class="professional-button-success">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Excel
                            </a>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard') }}" class="professional-button">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Records Table -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-primary-900">Annulment Records</h3>
                <p class="text-sm text-primary-500 mt-1">All annulment individual profiles</p>
            </div>
            <div class="professional-section-content">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-primary-200" style="min-width: 1200px;">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-48">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-32">IC No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Others</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Court Case</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-24">Release Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-32">Updated Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Release Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-40">Branch</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-primary-200">
                            @forelse($annulmentIndv as $annulment)
                                <tr class="hover:bg-primary-50 transition-colors duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-600">{{ $annulment->ic_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->others ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->court_case_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">
                                            @if($annulment->release_date)
                                                @if(is_string($annulment->release_date))
                                                    {{ \Carbon\Carbon::parse($annulment->release_date)->format('d/m/Y') }}
                                                @else
                                                    {{ $annulment->release_date->format('d/m/Y') }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->formatted_updated_date }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->release_type ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-primary-900">{{ $annulment->branch ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('annulment-indv.show', $annulment) }}" class="text-accent-600 hover:text-accent-700 transition-colors duration-200">View</a>
                                            <a href="{{ route('annulment-indv.edit', $annulment) }}" class="text-green-600 hover:text-green-700 transition-colors duration-200">Edit</a>
                                            <form method="POST" action="{{ route('annulment-indv.destroy', $annulment) }}" class="inline" onsubmit="return confirmDeleteAnnulment(event)">
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

<script>
function confirmDeleteAnnulment(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this annulment record!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.closest('form').submit();
        }
    });
}
</script>
@endsection
