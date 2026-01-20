@extends('layouts.app')

@section('title', 'Bulk Upload Annulment Records')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900">Bulk Upload Annulment Records</h1>
            <p class="text-neutral-800 mt-2">Upload multiple annulment records from Excel file</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-neutral-900 mb-4">Upload Excel File</h3>
                
                <form method="POST" action="{{ route('annulment-indv.bulk-upload.process') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-neutral-700 mb-2">
                            Excel File <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                               id="file" 
                               name="file" 
                               accept=".xlsx,.xls,.csv" 
                               required
                               class="block w-full text-sm text-neutral-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-neutral-50 file:text-neutral-700 hover:file:bg-neutral-100">
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-4">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Excel File Format Requirements</h4>
                        <ul class="text-sm text-blue-700 list-disc pl-5 space-y-1">
                            <li>Required fields: name, ic_no</li>
                            <li>Optional fields: others, court_case_no, release_date, updated_date, release_type, branch</li>
                            <li>Maximum file size: 50MB</li>
                            <li>Supported formats: .xlsx, .xls, .csv</li>
                        </ul>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('annulment-indv.index') }}" class="btn-outline">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Upload Records
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
