@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Annulment Individual Profile Details</h2>
                        <p class="text-gray-600 mt-1">View annulment individual information</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('annulment-indv.edit', $annulmentIndv) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            Edit Annulment Individual
                        </a>
                        <a href="{{ route('annulment-indv.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            Back to Annulment Individual List
                        </a>
                    </div>
                </div>

                <!-- Annulment Individual Details Card -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Annulment Individual ID -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Annulment Individual ID</label>
                            <p class="text-lg font-semibold text-blue-600">{{ $annulmentIndv->annulment_indv_id }}</p>
                        </div>

                        <!-- No Involvency -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">No Involvency</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->no_involvency ?? 'Not provided' }}</p>
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->name ?? 'Not provided' }}</p>
                        </div>

                        <!-- IC No -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">IC No</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->ic_no ?? 'Not provided' }}</p>
                        </div>

                        <!-- IC No 2 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">IC No 2</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->ic_no_2 ?? 'Not provided' }}</p>
                        </div>

                        <!-- Court Case Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Court Case Number</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->court_case_number ?? 'Not provided' }}</p>
                        </div>

                        <!-- RO Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">RO Date</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->ro_date ? $annulmentIndv->ro_date->format('d/m/Y') : 'Not provided' }}</p>
                        </div>

                        <!-- AO Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">AO Date</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->ao_date ? $annulmentIndv->ao_date->format('d/m/Y') : 'Not provided' }}</p>
                        </div>

                        <!-- Updated Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Updated Date</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->updated_date ? $annulmentIndv->updated_date->format('d/m/Y') : 'Not provided' }}</p>
                        </div>

                        <!-- Branch Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Branch Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->branch_name ?? 'Not provided' }}</p>
                        </div>


                        <!-- Created Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Created Date</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $annulmentIndv->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-center space-x-4">
                    <a href="{{ route('annulment-indv.edit', $annulmentIndv) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Edit Profile
                    </a>
                    <form method="POST" action="{{ route('annulment-indv.destroy', $annulmentIndv) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this annulment individual?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                            Delete Annulment Individual
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
