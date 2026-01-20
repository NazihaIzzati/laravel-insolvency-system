@extends('layouts.app')

@section('title', 'Bulk Upload Non-Individual Annulment Data')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900">Bulk Upload Non-Individual Annulment Records</h1>
                    <p class="text-neutral-800 mt-2">Upload multiple non-individual annulment records from Excel file</p>
                </div>
                <a href="{{ route('annulment-non-indv.index') }}" class="professional-button">
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
                <h3 class="text-lg font-medium text-neutral-900">Upload Excel File</h3>
                <p class="text-sm text-neutral-700 mt-1">Select an Excel file containing non-individual annulment records</p>
            </div>
            <div class="professional-section-content">
                <form method="POST" action="{{ route('annulment-non-indv.bulk-upload.process') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- File Upload -->
                    <div>
                        <label for="file" class="form-label">Excel File <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200" id="drop-zone">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-neutral-800">
                                    <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span id="upload-text">Upload a file</span>
                                        <input id="file" name="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required onchange="handleFileSelect(event)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-neutral-700">Excel files up to 2MB</p>
                                <div id="file-info" class="hidden mt-2">
                                    <p class="text-sm text-green-600 font-medium" id="file-name-display"></p>
                                </div>
                            </div>
                        </div>
                        @error('file')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Template Download -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-neutral-900">Need a template?</h4>
                                <p class="text-sm text-neutral-800">Download our Excel template with sample data and proper formatting</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('annulment-non-indv.template') }}" class="btn-outline">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Download Template
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar (Hidden by default) -->
                    <div id="upload-progress" class="hidden">
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span id="progress-text">Uploading...</span>
                                <span id="progress-percentage">0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div id="progress-bar" class="bg-orange-500 h-2.5 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 text-center">
                            <span id="upload-status">Preparing upload...</span>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3" id="upload-buttons">
                        <a href="{{ route('annulment-non-indv.index') }}" class="btn-outline">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary" id="upload-btn" disabled>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload File
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
    const uploadBtn = document.getElementById('upload-btn');
    const dropZone = document.getElementById('drop-zone');
    const fileInfo = document.getElementById('file-info');
    const fileNameDisplay = document.getElementById('file-name-display');
    const uploadText = document.getElementById('upload-text');
    
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
            uploadBtn.disabled = true;
            fileInfo.classList.add('hidden');
            uploadText.textContent = 'Upload a file';
            return;
        }
        
        // Validate file size (2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB in bytes
        if (file.size > maxSize) {
            Swal.fire({
                title: 'File Too Large',
                text: 'File size must be less than 2MB.',
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
            event.target.value = '';
            uploadBtn.disabled = true;
            fileInfo.classList.add('hidden');
            uploadText.textContent = 'Upload a file';
            return;
        }
        
        // Show file name and enable upload button
        fileNameDisplay.textContent = `Selected: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
        fileInfo.classList.remove('hidden');
        uploadText.textContent = 'Change file';
        
        uploadBtn.disabled = false;
        dropZone.classList.remove('border-neutral-300');
        dropZone.classList.add('border-green-300', 'bg-green-50');
        
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
        uploadBtn.disabled = true;
        dropZone.classList.remove('border-green-300', 'bg-green-50');
        dropZone.classList.add('border-neutral-300');
        fileInfo.classList.add('hidden');
        uploadText.textContent = 'Upload a file';
    }
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file');
    const form = document.querySelector('form');
    const uploadProgress = document.getElementById('upload-progress');
    const uploadButtons = document.getElementById('upload-buttons');
    const progressBar = document.getElementById('progress-bar');
    const progressPercentage = document.getElementById('progress-percentage');
    const progressText = document.getElementById('progress-text');
    const uploadStatus = document.getElementById('upload-status');
    
    // Drag and drop events
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-50');
    });
    
    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            // Trigger the file selection handler
            handleFileSelect({ target: fileInput });
        }
    });
    
    // Form submission with progress tracking
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const file = fileInput.files[0];
        
        if (!file) {
            Swal.fire({
                title: 'No File Selected',
                text: 'Please select a file to upload.',
                icon: 'warning',
                confirmButtonColor: '#f97316',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Show progress bar and hide buttons
        uploadProgress.classList.remove('hidden');
        uploadButtons.classList.add('hidden');
        
        // Reset progress
        updateProgress(0, 'Preparing upload...');
        
        // Create XMLHttpRequest for progress tracking
        const xhr = new XMLHttpRequest();
        
        // Upload progress event
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                updateProgress(percentComplete, 'Uploading file...');
            }
        });
        
        // Upload complete event
        xhr.addEventListener('load', function() {
            if (xhr.status === 200) {
                updateProgress(100, 'Processing data...');
                
                // Simulate processing time
                setTimeout(() => {
                    updateProgress(100, 'Upload completed successfully!');
                    
                    // Show success message
                    Swal.fire({
                        title: 'Upload Successful!',
                        text: 'Your file has been uploaded and processed successfully.',
                        icon: 'success',
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Redirect to index page
                        window.location.href = '{{ route("annulment-non-indv.index") }}';
                    });
                }, 2000);
            } else {
                // Handle error
                updateProgress(0, 'Upload failed');
                uploadProgress.classList.add('hidden');
                uploadButtons.classList.remove('hidden');
                
                Swal.fire({
                    title: 'Upload Failed',
                    text: 'There was an error uploading your file. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            }
        });
        
        // Upload error event
        xhr.addEventListener('error', function() {
            updateProgress(0, 'Upload failed');
            uploadProgress.classList.add('hidden');
            uploadButtons.classList.remove('hidden');
            
            Swal.fire({
                title: 'Upload Error',
                text: 'There was an error uploading your file. Please check your connection and try again.',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK'
            });
        });
        
        // Start upload
        xhr.open('POST', form.action);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.send(formData);
    });
    
    function updateProgress(percentage, status) {
        progressBar.style.width = percentage + '%';
        progressPercentage.textContent = Math.round(percentage) + '%';
        uploadStatus.textContent = status;
        
        if (percentage === 100) {
            progressText.textContent = 'Completed';
        } else if (percentage > 0) {
            progressText.textContent = 'Uploading...';
        } else {
            progressText.textContent = 'Preparing...';
        }
    }
});
</script>
@endsection