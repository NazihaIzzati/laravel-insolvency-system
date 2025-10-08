@extends('layouts.app')

@section('title', 'Bulk Upload Non-Individual Annulment Records')

@section('content')
<div class="min-h-screen bg-neutral-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-neutral-900 to-accent-600 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-12">
                <div class="text-white">
                    <h1 class="text-4xl font-light mb-3">Bulk Upload Non-Individual Annulment Records</h1>
                    <p class="text-xl text-primary-100 mb-2">Upload multiple non-individual annulment records at once</p>
                    <p class="text-primary-200">Use Excel files to import company annulment data efficiently</p>
                </div>
            </div>
        </div>

        <!-- Upload Instructions -->
        <div class="professional-section mb-6">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-neutral-900">Upload Instructions</h3>
                <p class="text-sm text-neutral-700 mt-1">Follow these steps to upload your data successfully</p>
            </div>
            <div class="professional-section-content">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Step 1 -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mr-4">
                                <span class="text-xl font-bold text-blue-600">1</span>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Download Template</h4>
                        </div>
                        <p class="text-neutral-800 text-sm mb-4">Download the Excel template to ensure proper formatting</p>
                        <a href="{{ route('annulment-non-indv.template') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Download Template
                        </a>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                        <div class="flex items-center mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mr-4">
                                <span class="text-xl font-bold text-green-600">2</span>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Fill Data</h4>
                        </div>
                        <p class="text-neutral-800 text-sm mb-4">Complete the template with your non-individual annulment data</p>
                        <div class="text-xs text-neutral-700">
                            <p>• Company Name (required)</p>
                            <p>• Company Registration No (required)</p>
                            <p>• Others, Court Case No, Date Update, Release type, Stay Order Date, Branch (optional)</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-full mr-4">
                                <span class="text-xl font-bold text-purple-600">3</span>
                            </div>
                            <h4 class="text-lg font-semibold text-neutral-900">Upload File</h4>
                        </div>
                        <p class="text-neutral-800 text-sm mb-4">Upload the completed Excel file using the form below</p>
                        <div class="text-xs text-neutral-700">
                            <p>• Supported: .xlsx, .xls</p>
                            <p>• Max size: 50MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="professional-section">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-neutral-900">Upload File</h3>
                <p class="text-sm text-neutral-700 mt-1">Select and upload your Excel file</p>
            </div>
            <div class="professional-section-content">
                <form method="POST" action="{{ route('annulment-non-indv.bulk-upload.process') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- File Upload -->
                    <div class="bg-gradient-to-r from-neutral-50 to-neutral-50 rounded-xl border border-accent-200 p-8">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-12 h-12 bg-accent-100 rounded-full mr-4">
                                <i class="fas fa-upload text-neutral-800 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-neutral-900">Select Excel File</h4>
                                <p class="text-sm text-neutral-800 mt-1">Choose your non-individual annulment data file</p>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <input type="file" 
                                   id="file" 
                                   name="file" 
                                   accept=".xlsx,.xls"
                                   class="block w-full text-sm text-neutral-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-neutral-50 file:text-neutral-700 hover:file:bg-neutral-100 file:cursor-pointer @error('file') border-red-500 @enderror"
                                   required>
                            @error('file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-4 text-sm text-neutral-800">
                            <p class="flex items-center mb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                <strong>File Requirements:</strong>
                            </p>
                            <ul class="list-disc list-inside ml-6 space-y-1">
                                <li>File format: Excel (.xlsx or .xls)</li>
                                <li>Maximum file size: 50MB</li>
                                <li>First row should contain column headers</li>
                                <li>Required columns: Company Name, Company Registration No</li>
                                <li>Insolvency Number will be auto-generated from Company Registration No</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-neutral-200">
                        <a href="{{ route('annulment-non-indv.index') }}" class="professional-button">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" class="professional-button-primary">
                            <i class="fas fa-upload mr-2"></i>
                            Upload File
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sample Data Format -->
        <div class="professional-section mt-6">
            <div class="professional-section-header">
                <h3 class="text-lg font-medium text-neutral-900">Sample Data Format</h3>
                <p class="text-sm text-neutral-700 mt-1">Example of how your data should be structured</p>
            </div>
            <div class="professional-section-content">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-neutral-300">
                        <thead class="bg-white-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Company Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Company Registration No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Others</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Court Case No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Date Update</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Release type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Stay Order Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-700 uppercase tracking-wider">Branch</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3 text-sm text-neutral-900">ABC Company Sdn Bhd</td>
                                <td class="px-4 py-3 text-sm text-neutral-900">123456789012</td>
                                <td class="px-4 py-3 text-sm text-neutral-900">REF001</td>
                                <td class="px-4 py-3 text-sm text-neutral-900">CASE2024001</td>
                                <td class="px-4 py-3 text-sm text-neutral-900">2024-09-25</td>
                                <td class="px-4 py-3 text-sm text-neutral-900">Discharge</td>
                                <td class="px-4 py-3 text-sm text-neutral-900">2024-01-15</td>
                                <td class="px-4 py-3 text-sm text-neutral-900">Kuala Lumpur Branch</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
