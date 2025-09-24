@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Add New Annulment Individual</h2>
                        <p class="text-gray-600 mt-1">Create a new annulment individual profile</p>
                    </div>
                    <a href="{{ route('annulment-indv.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                        Back to Annulment Individual List
                    </a>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('annulment-indv.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Annulment Individual ID -->
                        <div>
                            <label for="annulment_indv_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Annulment Individual ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="annulment_indv_id" 
                                   name="annulment_indv_id" 
                                   value="{{ old('annulment_indv_id') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('annulment_indv_id') border-red-500 @enderror"
                                   placeholder="e.g., 104081"
                                   required>
                            @error('annulment_indv_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No Involvency -->
                        <div>
                            <label for="no_involvency" class="block text-sm font-medium text-gray-700 mb-2">
                                No Involvency
                            </label>
                            <input type="text" 
                                   id="no_involvency" 
                                   name="no_involvency" 
                                   value="{{ old('no_involvency') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('no_involvency') border-red-500 @enderror"
                                   placeholder="e.g., INV001">
                            @error('no_involvency')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                   placeholder="e.g., Ahmad Rahman"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- IC No -->
                        <div>
                            <label for="ic_no" class="block text-sm font-medium text-gray-700 mb-2">
                                IC No
                            </label>
                            <input type="text" 
                                   id="ic_no" 
                                   name="ic_no" 
                                   value="{{ old('ic_no') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ic_no') border-red-500 @enderror"
                                   placeholder="e.g., 123456789012">
                            @error('ic_no')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- IC No 2 -->
                        <div>
                            <label for="ic_no_2" class="block text-sm font-medium text-gray-700 mb-2">
                                IC No 2
                            </label>
                            <input type="text" 
                                   id="ic_no_2" 
                                   name="ic_no_2" 
                                   value="{{ old('ic_no_2') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ic_no_2') border-red-500 @enderror"
                                   placeholder="e.g., 987654321098">
                            @error('ic_no_2')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Court Case Number -->
                        <div>
                            <label for="court_case_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Court Case Number
                            </label>
                            <input type="text" 
                                   id="court_case_number" 
                                   name="court_case_number" 
                                   value="{{ old('court_case_number') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('court_case_number') border-red-500 @enderror"
                                   placeholder="e.g., CC2024001">
                            @error('court_case_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- RO Date -->
                        <div>
                            <label for="ro_date" class="block text-sm font-medium text-gray-700 mb-2">
                                RO Date
                            </label>
                            <input type="date" 
                                   id="ro_date" 
                                   name="ro_date" 
                                   value="{{ old('ro_date') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ro_date') border-red-500 @enderror">
                            @error('ro_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- AO Date -->
                        <div>
                            <label for="ao_date" class="block text-sm font-medium text-gray-700 mb-2">
                                AO Date
                            </label>
                            <input type="date" 
                                   id="ao_date" 
                                   name="ao_date" 
                                   value="{{ old('ao_date') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ao_date') border-red-500 @enderror">
                            @error('ao_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Updated Date -->
                        <div>
                            <label for="updated_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Updated Date
                            </label>
                            <input type="date" 
                                   id="updated_date" 
                                   name="updated_date" 
                                   value="{{ old('updated_date') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('updated_date') border-red-500 @enderror">
                            @error('updated_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Branch Name -->
                        <div>
                            <label for="branch_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Branch Name
                            </label>
                            <input type="text" 
                                   id="branch_name" 
                                   name="branch_name" 
                                   value="{{ old('branch_name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('branch_name') border-red-500 @enderror"
                                   placeholder="e.g., Kuala Lumpur Branch">
                            @error('branch_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                   placeholder="e.g., john.doe@company.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                   placeholder="e.g., +60123456789">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('annulment-indv.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                            Create Annulment Individual
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
