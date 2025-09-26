@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Bankruptcy Record</h1>
                    <p class="mt-2 text-gray-600">Update the bankruptcy record information</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('bankruptcy.show', $bankruptcy) }}" 
                       class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View Record
                    </a>
                    <a href="{{ route('bankruptcy.index') }}" 
                       class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('bankruptcy.update', $bankruptcy) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="insolvency_no" class="block text-sm font-medium text-gray-700 mb-2">
                                    Insolvency Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="insolvency_no" 
                                       name="insolvency_no" 
                                       value="{{ old('insolvency_no', $bankruptcy->insolvency_no) }}"
                                       class="form-input w-full @error('insolvency_no') border-red-500 @enderror" 
                                       placeholder="e.g., BP001234/2025"
                                       required>
                                @error('insolvency_no')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $bankruptcy->name) }}"
                                       class="form-input w-full @error('name') border-red-500 @enderror" 
                                       placeholder="e.g., Ahmad Rahman"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ic_no" class="block text-sm font-medium text-gray-700 mb-2">
                                    IC Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="ic_no" 
                                       name="ic_no" 
                                       value="{{ old('ic_no', $bankruptcy->ic_no) }}"
                                       class="form-input w-full @error('ic_no') border-red-500 @enderror" 
                                       placeholder="e.g., 123456789012"
                                       required>
                                @error('ic_no')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="others" class="block text-sm font-medium text-gray-700 mb-2">
                                    Others
                                </label>
                                <input type="text" 
                                       id="others" 
                                       name="others" 
                                       value="{{ old('others', $bankruptcy->others) }}"
                                       class="form-input w-full @error('others') border-red-500 @enderror" 
                                       placeholder="Additional information">
                                @error('others')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Case Information Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Case Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="court_case_no" class="block text-sm font-medium text-gray-700 mb-2">
                                    Court Case Number
                                </label>
                                <input type="text" 
                                       id="court_case_no" 
                                       name="court_case_no" 
                                       value="{{ old('court_case_no', $bankruptcy->court_case_no) }}"
                                       class="form-input w-full @error('court_case_no') border-red-500 @enderror" 
                                       placeholder="e.g., BA-29NCC-1234-01/2024">
                                @error('court_case_no')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="branch" class="block text-sm font-medium text-gray-700 mb-2">
                                    Branch
                                </label>
                                <input type="text" 
                                       id="branch" 
                                       name="branch" 
                                       value="{{ old('branch', $bankruptcy->branch) }}"
                                       class="form-input w-full @error('branch') border-red-500 @enderror" 
                                       placeholder="e.g., Pejabat Negeri Selangor">
                                @error('branch')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dates Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Important Dates</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="ro_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    RO Date
                                </label>
                                <input type="date" 
                                       id="ro_date" 
                                       name="ro_date" 
                                       value="{{ old('ro_date', $bankruptcy->ro_date ? $bankruptcy->ro_date->format('Y-m-d') : '') }}"
                                       class="form-input w-full @error('ro_date') border-red-500 @enderror">
                                @error('ro_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ao_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    AO Date
                                </label>
                                <input type="date" 
                                       id="ao_date" 
                                       name="ao_date" 
                                       value="{{ old('ao_date', $bankruptcy->ao_date ? $bankruptcy->ao_date->format('Y-m-d') : '') }}"
                                       class="form-input w-full @error('ao_date') border-red-500 @enderror">
                                @error('ao_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="updated_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Updated Date
                                </label>
                                <input type="date" 
                                       id="updated_date" 
                                       name="updated_date" 
                                       value="{{ old('updated_date', $bankruptcy->updated_date ? $bankruptcy->updated_date->format('Y-m-d') : '') }}"
                                       class="form-input w-full @error('updated_date') border-red-500 @enderror">
                                @error('updated_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status Section -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Status</h3>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $bankruptcy->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Active Record
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Uncheck to deactivate this record</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('bankruptcy.show', $bankruptcy) }}" 
                           class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
