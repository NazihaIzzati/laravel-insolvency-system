@extends('layouts.app')

@section('title', 'Bulk Upload Annulment Records')

@section('content')
<div class="min-h-screen bg-primary-50">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-primary-900">Bulk Upload Annulment Records</h1>
                    <p class="text-primary-600 mt-2">Upload multiple annulment records from Excel file</p>
                </div>
                <a href="{{ route('annulment-indv.index') }}" class="professional-button">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Records
                </a>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-primary-900">Upload Excel File</h3>
                <p class="text-sm text-primary-500 mt-1">Select an Excel file containing annulment records</p>
            </div>
            <div class="professional-section-content">
                <form method="POST" action="{{ route('annulment-indv.bulk-upload') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- File Upload -->
                    <div>
                        <label for="file" class="form-label">Excel File <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-primary-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        <span>Upload a file</span>
                                        <input id="file" name="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required onchange="handleFileSelect(event)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">Excel files up to 50MB</p>
                            </div>
                        </div>
                        @error('file')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Info Display -->
                    <div id="file-info" class="hidden">
                        <div class="bg-green-50 border border-green-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">File Selected</h3>
                                    <div class="mt-2 text-sm text-green-700">
                                        <p id="file-name"></p>
                                        <p id="file-size"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Excel File Format Requirements</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>Download the Excel template to see the required format</li>
                                        <li>Fill in your annulment data following the template structure</li>
                                        <li>Required fields: name, ic_no</li>
                                        <li>Optional fields: others, court_case_no, release_date, updated_date, release_type, branch</li>
                                        <li>Dates should be in YYYY-MM-DD format</li>
                                        <li>Maximum file size: 50MB (large files will be processed with optimized memory management)</li>
                                        <li>Supported formats: .xlsx, .xls, .csv</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expected Columns -->
                    <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                        <h4 class="text-sm font-medium text-gray-800 mb-3">Expected Excel Columns:</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600">
                            <div>
                                <p class="font-medium text-gray-700">Column A:</p>
                                <p>• name (Nama)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Column B:</p>
                                <p>• ic_no (No. K/P Baru)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Column C:</p>
                                <p>• others (No. Lain)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Column D:</p>
                                <p>• court_case_no (No. Kes Mahkamah)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Column E:</p>
                                <p>• release_date (Tarikh Pelepasan)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Column F:</p>
                                <p>• updated_date (Tarikh Kemaskini)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Column G:</p>
                                <p>• release_type (Jenis Pelepasan)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Column H:</p>
                                <p>• branch (Nama Cawangan)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('annulment-indv.index') }}" class="btn-outline">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary" id="upload-btn" disabled>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload Records
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function handleFileSelect(event) {
    const file = event.target.files[0];
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const uploadBtn = document.getElementById('upload-btn');
    
    if (file) {
        // Validate file type
        const allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
                             'application/vnd.ms-excel', 
                             'text/csv'];
        
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                title: 'Invalid File Type',
                text: 'Please select an Excel file (.xlsx, .xls) or CSV file.',
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
            event.target.value = '';
            return;
        }
        
        // Validate file size (50MB)
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        if (file.size > maxSize) {
            Swal.fire({
                title: 'File Too Large',
                text: 'File size must be less than 50MB.',
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
            event.target.value = '';
            return;
        }
        
        // Show file info
        fileName.textContent = `File: ${file.name}`;
        fileSize.textContent = `Size: ${(file.size / 1024 / 1024).toFixed(2)} MB`;
        fileInfo.classList.remove('hidden');
        uploadBtn.disabled = false;
        
        // Show success message
        Swal.fire({
            title: 'File Selected',
            text: 'File is ready for upload.',
            icon: 'success',
            confirmButtonColor: '#22c55e',
            confirmButtonText: 'OK',
            timer: 3000,
            timerProgressBar: true
        });
    } else {
        fileInfo.classList.add('hidden');
        uploadBtn.disabled = true;
    }
}
</script>
@endsection
