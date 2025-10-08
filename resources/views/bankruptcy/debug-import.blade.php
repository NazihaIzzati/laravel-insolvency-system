@extends('layouts.app')

@section('title', 'Debug Excel Import')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-neutral-900">Debug Excel Import</h1>
                    <p class="mt-1 text-sm text-neutral-800">Analyze your Excel file structure to identify import issues</p>
                </div>
                <a href="{{ route('bankruptcy.bulk-upload') }}" class="btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Bulk Upload
                </a>
            </div>
        </div>
    </div>

    <!-- Debug Form -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form id="debugForm" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- File Upload -->
                <div>
                    <label for="excel_file" class="form-label">Upload Your Excel File</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-800" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-neutral-800">
                                <label for="excel_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="excel_file" name="excel_file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-neutral-700">Excel files up to 10MB</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Analyze File
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results -->
    <div id="results" class="hidden bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-neutral-900 mb-4">File Analysis Results</h3>
            <div id="resultsContent"></div>
        </div>
    </div>

    <!-- Expected Format -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Expected Column Headers</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p class="mb-2">Your Excel file should have these column headers (case-insensitive):</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold">Required:</h4>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>insolvency_no (or bankruptcy_id, insolvency_number, no_involvency)</li>
                                <li>name (or full_name, person_name)</li>
                                <li>ic_no (or ic_number, ic, identity_card)</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold">Optional:</h4>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>others (or additional_info, remarks, notes)</li>
                                <li>court_case_no (or case_number, court_case_number)</li>
                                <li>ro_date, ao_date, updated_date</li>
                                <li>branch (or branch_name, office)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const debugForm = document.getElementById('debugForm');
    const results = document.getElementById('results');
    const resultsContent = document.getElementById('resultsContent');
    const fileInput = document.getElementById('excel_file');
    const dropZone = fileInput.closest('.border-dashed');
    
    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            
            const label = dropZone.querySelector('label span');
            label.textContent = fileName + ' (' + fileSize + ' MB)';
            
            dropZone.classList.remove('border-neutral-300');
            dropZone.classList.add('border-green-300', 'bg-green-50');
        }
    });
    
    // Handle form submission
    debugForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("bankruptcy.debug-import") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayResults(data);
            } else {
                resultsContent.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Error</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>${data.error}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                results.classList.remove('hidden');
            }
        })
        .catch(error => {
            resultsContent.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Error</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>An error occurred: ${error.message}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            results.classList.remove('hidden');
        });
    });
    
    function displayResults(data) {
        const expectedHeaders = ['insolvency_no', 'name', 'ic_no', 'others', 'court_case_no', 'ro_date', 'ao_date', 'updated_date', 'branch'];
        const foundHeaders = data.headers || [];
        const missingHeaders = expectedHeaders.filter(h => !foundHeaders.some(fh => fh.toLowerCase().includes(h.toLowerCase())));
        const extraHeaders = foundHeaders.filter(fh => !expectedHeaders.some(h => fh.toLowerCase().includes(h.toLowerCase())));
        
        let html = `
            <div class="space-y-4">
                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                    <h4 class="text-sm font-medium text-green-800 mb-2">File Information</h4>
                    <ul class="text-sm text-green-700 space-y-1">
                        <li>Total rows: ${data.total_rows}</li>
                        <li>Headers found: ${foundHeaders.length}</li>
                    </ul>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">Column Headers Found</h4>
                    <div class="text-sm text-blue-700">
                        <code class="bg-blue-100 px-2 py-1 rounded">${foundHeaders.join(', ')}</code>
                    </div>
                </div>
        `;
        
        if (missingHeaders.length > 0) {
            html += `
                <div class="bg-neutral-50 border border-neutral-200 rounded-md p-4">
                    <h4 class="text-sm font-medium text-yellow-800 mb-2">Missing Required Headers</h4>
                    <ul class="text-sm text-yellow-700 space-y-1">
                        ${missingHeaders.map(h => `<li>• ${h}</li>`).join('')}
                    </ul>
                </div>
            `;
        }
        
        if (extraHeaders.length > 0) {
            html += `
                <div class="bg-white-50 border border-neutral-200 rounded-md p-4">
                    <h4 class="text-sm font-medium text-gray-800 mb-2">Extra Headers (will be ignored)</h4>
                    <ul class="text-sm text-neutral-700 space-y-1">
                        ${extraHeaders.map(h => `<li>• ${h}</li>`).join('')}
                    </ul>
                </div>
            `;
        }
        
        html += `
                <div class="bg-white-50 border border-neutral-200 rounded-md p-4">
                    <h4 class="text-sm font-medium text-gray-800 mb-2">Sample Data (First Row)</h4>
                    <div class="text-sm text-neutral-700">
                        <pre class="bg-gray-100 p-3 rounded overflow-x-auto">${JSON.stringify(data.first_row, null, 2)}</pre>
                    </div>
                </div>
            </div>
        `;
        
        resultsContent.innerHTML = html;
        results.classList.remove('hidden');
    }
});
</script>
@endsection


