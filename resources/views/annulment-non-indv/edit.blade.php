@extends('layouts.app')

@section('title', 'Edit Non-Individual Annulment Record')

@section('content')
<div class="min-h-screen bg-neutral-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-neutral-900 to-accent-600 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-12">
                <div class="text-white">
                    <h1 class="text-4xl font-light mb-3">Edit Non-Individual Annulment Record</h1>
                    <p class="text-xl text-primary-100 mb-2">Update company annulment information</p>
                    <p class="text-primary-200">Modify company details and annulment data</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-neutral-900">Company Information</h3>
                <p class="text-sm text-neutral-700 mt-1">Update the company and annulment details</p>
            </div>
            <div class="professional-section-content">
                <form method="POST" action="{{ route('annulment-non-indv.update', $annulmentNonIndv) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Insolvency Number -->
                        <div>
                            <label for="insolvency_no" class="block text-sm font-medium text-neutral-700 mb-2">
                                Insolvency Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="insolvency_no" 
                                   name="insolvency_no" 
                                   value="{{ old('insolvency_no', $annulmentNonIndv->insolvency_no) }}"
                                   class="professional-input @error('insolvency_no') border-red-500 @enderror"
                                   placeholder="Enter insolvency number"
                                   required>
                            @error('insolvency_no')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-neutral-700 mb-2">
                                Company Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="company_name" 
                                   name="company_name" 
                                   value="{{ old('company_name', $annulmentNonIndv->company_name) }}"
                                   class="professional-input @error('company_name') border-red-500 @enderror"
                                   placeholder="Enter company name"
                                   required>
                            @error('company_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Registration Number -->
                        <div>
                            <label for="company_registration_no" class="block text-sm font-medium text-neutral-700 mb-2">
                                Company Registration Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="company_registration_no" 
                                   name="company_registration_no" 
                                   value="{{ old('company_registration_no', $annulmentNonIndv->company_registration_no) }}"
                                   class="professional-input @error('company_registration_no') border-red-500 @enderror"
                                   placeholder="Enter company registration number"
                                   required>
                            @error('company_registration_no')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Others -->
                        <div>
                            <label for="others" class="block text-sm font-medium text-neutral-700 mb-2">
                                Others
                            </label>
                            <input type="text" 
                                   id="others" 
                                   name="others" 
                                   value="{{ old('others', $annulmentNonIndv->others) }}"
                                   class="professional-input @error('others') border-red-500 @enderror"
                                   placeholder="Enter other reference numbers">
                            @error('others')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Court Case Number -->
                        <div>
                            <label for="court_case_no" class="block text-sm font-medium text-neutral-700 mb-2">
                                Court Case Number
                            </label>
                            <input type="text" 
                                   id="court_case_no" 
                                   name="court_case_no" 
                                   value="{{ old('court_case_no', $annulmentNonIndv->court_case_no) }}"
                                   class="professional-input @error('court_case_no') border-red-500 @enderror"
                                   placeholder="Enter court case number">
                            @error('court_case_no')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Release Date -->
                        <div>
                            <label for="release_date" class="block text-sm font-medium text-neutral-700 mb-2">
                                Release Date
                            </label>
                            <input type="date" 
                                   id="release_date" 
                                   name="release_date" 
                                   value="{{ old('release_date', $annulmentNonIndv->release_date ? $annulmentNonIndv->release_date->format('Y-m-d') : '') }}"
                                   class="professional-input @error('release_date') border-red-500 @enderror">
                            @error('release_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Release Type -->
                        <div>
                            <label for="release_type" class="block text-sm font-medium text-neutral-700 mb-2">
                                Release Type
                            </label>
                            <input type="text" 
                                   id="release_type" 
                                   name="release_type" 
                                   value="{{ old('release_type', $annulmentNonIndv->release_type) }}"
                                   class="professional-input @error('release_type') border-red-500 @enderror"
                                   placeholder="Enter release type">
                            @error('release_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Branch -->
                        <div>
                            <label for="branch" class="block text-sm font-medium text-neutral-700 mb-2">
                                Branch
                            </label>
                            <input type="text" 
                                   id="branch" 
                                   name="branch" 
                                   value="{{ old('branch', $annulmentNonIndv->branch) }}"
                                   class="professional-input @error('branch') border-red-500 @enderror"
                                   placeholder="Enter branch name">
                            @error('branch')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-neutral-200">
                        <a href="{{ route('annulment-non-indv.index') }}" class="professional-button">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" class="professional-button-primary">
                            <i class="fas fa-save mr-2"></i>
                            Update Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
