@extends('layouts.app')

@section('title', 'Bulk Upload Bankruptcy Data')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Bulk Upload Bankruptcy Data</h1>
                    <p class="text-gray-600 mt-1">Upload multiple bankruptcy records at once using Excel file</p>
                </div>
                <a href="{{ route('bankruptcy.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                   style="background-color: #dc2626;"
                   onmouseover="this.style.backgroundColor='#b91c1c';"
                   onmouseout="this.style.backgroundColor='#dc2626';">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Bankruptcy Records
                </a>
            </div>
        </div>

        <!-- Instructions Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-blue-900">Upload Instructions</h3>
                    <div class="mt-2 text-sm text-blue-800">
                        <p class="mb-2">Follow these steps to upload bankruptcy records in bulk:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Download the Excel template using the button below</li>
                            <li>Fill in the bankruptcy information following the template format</li>
                            <li>Ensure all required fields are filled correctly</li>
                            <li>Upload the completed Excel file</li>
                        </ol>
                        <div class="mt-3 text-xs text-blue-700">
                            <p><strong>Required fields:</strong> insolvency_no, name, ic_no</p>
                            <p><strong>Optional fields:</strong> others, court_case_no, ro_date, ao_date, updated_date, branch</p>
                            <p><strong>Date format:</strong> YYYY-MM-DD | <strong>Max file size:</strong> 10MB | <strong>Supported formats:</strong> .xlsx, .xls, .csv</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Upload Bankruptcy Records</h3>
                <p class="text-sm text-gray-500 mt-1">Select your Excel file to upload bankruptcy records</p>
            </div>
            
            <form action="{{ route('bankruptcy.bulk-upload.process') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <!-- File Upload -->
                <div class="mb-6">
                    <label for="excel_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Excel File <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-orange-300 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-4"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="excel_file" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                    <span>Upload a file</span>
                                    <input id="excel_file" name="excel_file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">Excel files only (XLSX, XLS, CSV) up to 10MB</p>
                        </div>
                    </div>
                    @error('excel_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Preview -->
                <div id="file-preview" class="hidden mb-6">
                    <div class="bg-white rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-file-excel text-green-600 text-xl mr-3"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900" id="file-name"></p>
                                <p class="text-xs text-gray-500" id="file-size"></p>
                            </div>
                            <button type="button" id="remove-file" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('bankruptcy.template') }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>
                        Download Template
                    </a>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('bankruptcy.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" id="upload-btn" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            <span id="upload-text">Upload Records</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Loading Progress Card -->
        <div id="loading-progress" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Uploading Bankruptcy Records</h3>
                <p class="text-sm text-gray-500 mt-1">Please wait while we process your data...</p>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-spinner fa-spin text-orange-600 text-xl"></i>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                    <div id="progress-bar" class="bg-orange-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <div class="text-center">
                    <p id="progress-text" class="text-sm text-gray-600">Preparing upload...</p>
                    <p id="progress-details" class="text-xs text-gray-500 mt-1">Please do not close this page</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('excel_file');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFileBtn = document.getElementById('remove-file');
    const uploadBtn = document.getElementById('upload-btn');
    const uploadText = document.getElementById('upload-text');
    const loadingProgress = document.getElementById('loading-progress');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const progressDetails = document.getElementById('progress-details');
    const dropZone = fileInput.closest('.border-dashed');
    
    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            showFilePreview(file);
        }
    });
    
    // Handle remove file
    removeFileBtn.addEventListener('click', function() {
        fileInput.value = '';
        hideFilePreview();
    });
    
    // Handle drag and drop
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-orange-400', 'bg-orange-50');
    });
    
    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-orange-400', 'bg-orange-50');
    });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-orange-400', 'bg-orange-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });
    
    // Handle form submission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (fileInput.files.length === 0) {
            e.preventDefault();
            alert('Please select a file to upload.');
            return;
        }
        
        showLoadingProgress();
    });
    
    function showFilePreview(file) {
        const fileNameText = file.name;
        const fileSizeText = formatFileSize(file.size);
        
        fileName.textContent = fileNameText;
        fileSize.textContent = fileSizeText;
        
        filePreview.classList.remove('hidden');
        dropZone.classList.add('hidden');
    }
    
    function hideFilePreview() {
        filePreview.classList.add('hidden');
        dropZone.classList.remove('hidden');
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    function showLoadingProgress() {
        loadingProgress.classList.remove('hidden');
        uploadBtn.disabled = true;
        uploadText.textContent = 'Uploading...';
        
        // Simulate progress
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 90) progress = 90;
            
            progressBar.style.width = progress + '%';
            progressText.textContent = `Uploading... ${Math.round(progress)}%`;
            
            if (progress >= 90) {
                clearInterval(interval);
                progressText.textContent = 'Finalizing upload...';
                progressDetails.textContent = 'Almost done, please wait...';
            }
        }, 500);
    }
});
</script>
@endsection
