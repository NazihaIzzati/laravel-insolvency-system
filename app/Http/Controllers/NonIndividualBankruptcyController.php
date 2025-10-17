<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NonIndividualBankruptcy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NonIndividualBankruptcyImport;
use Illuminate\Support\Facades\Storage;

class NonIndividualBankruptcyController extends Controller
{
    /**
     * Display the upload form
     */
    public function create()
    {
        return view('non-individual-bankruptcy.create');
    }

    /**
     * Store non-individual bankruptcy data
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'insolvency_no' => 'required|string|unique:non_individual_bankruptcies,insolvency_no',
            'company_name' => 'required|string|max:255',
            'company_registration_no' => 'required|string|max:20',
            'others' => 'nullable|string',
            'court_case_no' => 'nullable|string',
            'date_of_winding_up_resolution' => 'nullable|string',
            'updated_date' => 'nullable|string',
            'branch' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();
            
            // Convert date formats
            if (!empty($data['date_of_winding_up_resolution'])) {
                $data['date_of_winding_up_resolution'] = $this->convertDateFormat($data['date_of_winding_up_resolution']);
            }
            // Don't convert updated_date - let the model handle it with the boot method
            
            $nonIndividualBankruptcy = NonIndividualBankruptcy::create($data);

            return redirect()->route('non-individual-bankruptcy.index')
                ->with('success', 'Non-Individual Bankruptcy data uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while uploading data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display a listing of non-individual bankruptcies
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $nonIndividualBankruptcies = NonIndividualBankruptcy::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('non-individual-bankruptcy.index', compact('nonIndividualBankruptcies', 'perPage'));
    }

    /**
     * Search non-individual bankruptcy records
     */
    public function search(Request $request)
    {
        try {
            $searchValue = $request->input('search_input');
            
            if (empty($searchValue)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a search value.'
                ]);
            }

            $results = NonIndividualBankruptcy::where('is_active', true)
                ->where(function($query) use ($searchValue) {
                    $query->where('insolvency_no', 'LIKE', "%{$searchValue}%")
                          ->orWhere('company_name', 'LIKE', "%{$searchValue}%")
                          ->orWhere('company_registration_no', 'LIKE', "%{$searchValue}%")
                          ->orWhere('court_case_no', 'LIKE', "%{$searchValue}%");
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'results' => $results
            ]);

        } catch (\Exception $e) {
            \Log::error('Non-individual bankruptcy search error:', [
                'message' => $e->getMessage(),
                'search_value' => $request->input('search_input')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching. Please try again.'
            ]);
        }
    }

    /**
     * Display the specified non-individual bankruptcy
     */
    public function show(NonIndividualBankruptcy $nonIndividualBankruptcy)
    {
        return view('non-individual-bankruptcy.show', compact('nonIndividualBankruptcy'));
    }

    /**
     * Show the form for editing the specified non-individual bankruptcy
     */
    public function edit(NonIndividualBankruptcy $nonIndividualBankruptcy)
    {
        return view('non-individual-bankruptcy.edit', compact('nonIndividualBankruptcy'));
    }

    /**
     * Update the specified non-individual bankruptcy
     */
    public function update(Request $request, NonIndividualBankruptcy $nonIndividualBankruptcy)
    {
        $validator = Validator::make($request->all(), [
            'insolvency_no' => 'required|string|unique:non_individual_bankruptcies,insolvency_no,' . $nonIndividualBankruptcy->id,
            'company_name' => 'required|string|max:255',
            'company_registration_no' => 'required|string|max:20',
            'others' => 'nullable|string',
            'court_case_no' => 'nullable|string',
            'date_of_winding_up_resolution' => 'nullable|string',
            'updated_date' => 'nullable|string',
            'branch' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();
            
            // Convert date formats
            if (!empty($data['date_of_winding_up_resolution'])) {
                $data['date_of_winding_up_resolution'] = $this->convertDateFormat($data['date_of_winding_up_resolution']);
            }
            // Don't convert updated_date - let the model handle it with the boot method
            
            $nonIndividualBankruptcy->update($data);

            return redirect()->route('non-individual-bankruptcy.show', $nonIndividualBankruptcy)
                ->with('success', 'Non-Individual Bankruptcy data updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Convert date format from DD/MM/YYYY to YYYY-MM-DD for database storage
     */
    private function convertDateFormat($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        try {
            // Handle DD/MM/YYYY format
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}/', $dateString)) {
                $date = \Carbon\Carbon::createFromFormat('d/m/Y', $dateString);
                return $date->format('Y-m-d');
            }
            
            // Handle DD/MM/YYYY HH:MM AM/PM format
            if (preg_match('/^\d{2}\/\d{2}\/\d{4} \d{1,2}:\d{2} [AP]M/', $dateString)) {
                $date = \Carbon\Carbon::createFromFormat('d/m/Y g:i A', $dateString);
                return $date->format('Y-m-d H:i:s');
            }
            
            // If already in YYYY-MM-DD format, return as is
            if (preg_match('/^\d{4}-\d{2}-\d{2}/', $dateString)) {
                return $dateString;
            }
            
            // Try to parse with Carbon's flexible parser
            $date = \Carbon\Carbon::parse($dateString);
            return $date->format('Y-m-d');
            
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Remove the specified non-individual bankruptcy (soft delete)
     */
    public function destroy(NonIndividualBankruptcy $nonIndividualBankruptcy)
    {
        try {
            $nonIndividualBankruptcy->update(['is_active' => false]);

            return redirect()->route('non-individual-bankruptcy.index')
                ->with('success', 'Non-Individual Bankruptcy record deactivated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while deleting data: ' . $e->getMessage());
        }
    }

    /**
     * Show bulk upload form
     */
    public function bulkUpload()
    {
        return view('non-individual-bankruptcy.bulk-upload');
    }

    /**
     * Process bulk upload from Excel file
     */
    public function processBulkUpload(Request $request)
    {
        // Debug: Check if file is uploaded
        if (!$request->hasFile('excel_file')) {
            return redirect()->back()
                ->with('error', 'No file was uploaded. Please select a file.')
                ->withInput();
        }

        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048', // 2MB max (PHP limit)
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('excel_file');
            
            // Debug: Check file details
            \Log::info('=== FILE UPLOAD START ===', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'timestamp' => now()->toDateTimeString()
            ]);
            
            // Debug: Check database state before import
            $beforeCount = NonIndividualBankruptcy::count();
            $beforeSample = NonIndividualBankruptcy::limit(3)->get(['insolvency_no', 'company_name', 'date_of_winding_up_resolution', 'updated_date']);
            
            \Log::info('Database state BEFORE import:', [
                'total_records' => $beforeCount,
                'sample_records' => $beforeSample->toArray()
            ]);
            
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store file temporarily
            $file->storeAs('temp', $fileName);
            $filePath = storage_path('app/temp/' . $fileName);

            // Check if file exists
            if (!file_exists($filePath)) {
                throw new \Exception('File was not saved properly');
            }

            // Import data
            $import = new NonIndividualBankruptcyImport();
            Excel::import($import, $filePath);

            // Clean up temp file
            Storage::delete('temp/' . $fileName);

            $importedCount = $import->getRowCount();
            $updatedCount = $import->getSkippedDuplicates(); // Now represents updated records
            
            // Debug: Check database state after import
            $afterCount = NonIndividualBankruptcy::count();
            $afterSample = NonIndividualBankruptcy::limit(3)->get(['insolvency_no', 'company_name', 'date_of_winding_up_resolution', 'updated_date']);
            
            \Log::info('Database state AFTER import:', [
                'total_records' => $afterCount,
                'sample_records' => $afterSample->toArray(),
                'imported_count' => $importedCount,
                'updated_count' => $updatedCount
            ]);
            
            \Log::info('=== FILE UPLOAD COMPLETED ===', [
                'timestamp' => now()->toDateTimeString()
            ]);
            
            $message = "Successfully imported {$importedCount} new non-individual bankruptcy records.";
            if ($updatedCount > 0) {
                $message .= " {$updatedCount} existing records were updated.";
            }

            // Initialize empty arrays for errors and failures
            $errorsArray = [];
            $failuresArray = [];

            return redirect()->route('non-individual-bankruptcy.index')
                ->with('success', $message)
                ->with('import_errors', $errorsArray)
                ->with('import_failures', $failuresArray)
                ->with('debug_info', [
                    'imported_count' => $importedCount,
                    'updated_count' => $updatedCount,
                    'error_count' => count($errorsArray),
                    'failure_count' => count($failuresArray),
                    'first_few_failures' => array_slice($failuresArray, 0, 3)
                ]);

        } catch (\Exception $e) {
            // Clean up temp file if it exists
            if (isset($fileName) && Storage::exists('temp/' . $fileName)) {
                Storage::delete('temp/' . $fileName);
            }

            // Log the error for debugging
            \Log::error('Bulk upload error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred during bulk upload: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Download Excel template
     */
    public function downloadTemplate()
    {
        $templateData = [
            [
                'Insolvency No' => 'NINS001',
                'Company Name' => 'ABC Company Sdn Bhd',
                'Company Registration No' => '123456789012',
                'Others' => 'Additional information',
                'Court Case No' => 'CASE2024001',
                'Date of Winding Up/Resolution' => '2024-01-15',
                'Updated Date' => '2024-09-25',
                'Branch' => 'Kuala Lumpur Branch'
            ]
        ];

        $headers = [
            'Insolvency No', 'Company Name', 'Company Registration No', 'Others', 'Court Case No',
            'Date of Winding Up/Resolution', 'Updated Date', 'Branch'
        ];

        return Excel::download(new class($templateData, $headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            private $data;
            private $headers;

            public function __construct($data, $headers)
            {
                $this->data = $data;
                $this->headers = $headers;
            }

            public function array(): array
            {
                return array_merge([$this->headers], $this->data);
            }
        }, 'non_individual_bankruptcy_template.xlsx');
    }

    /**
     * Download all non-individual bankruptcy records as Excel file
     */
    public function downloadRecords()
    {
        try {
            // Get all active non-individual bankruptcy records
            $nonIndividualBankruptcies = NonIndividualBankruptcy::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();

            // Prepare data for export
            $exportData = [];
            foreach ($nonIndividualBankruptcies as $nonIndividualBankruptcy) {
                $exportData[] = [
                    'Insolvency No' => $nonIndividualBankruptcy->insolvency_no,
                    'Company Name' => $nonIndividualBankruptcy->company_name,
                    'Company Registration No' => $nonIndividualBankruptcy->company_registration_no,
                    'Others' => $nonIndividualBankruptcy->others ?? '',
                    'Court Case No' => $nonIndividualBankruptcy->court_case_no ?? '',
                    'Date of Winding Up/Resolution' => $nonIndividualBankruptcy->date_of_winding_up_resolution ? $nonIndividualBankruptcy->date_of_winding_up_resolution->format('Y-m-d') : '',
                    'Updated Date' => $nonIndividualBankruptcy->updated_date ? $nonIndividualBankruptcy->updated_date->format('Y-m-d') : '',
                    'Branch' => $nonIndividualBankruptcy->branch ?? ''
                ];
            }

            $headers = [
                'Insolvency No', 'Company Name', 'Company Registration No', 'Others', 'Court Case No',
                'Date of Winding Up/Resolution', 'Updated Date', 'Branch'
            ];

            $fileName = 'non_individual_bankruptcy_records_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            return Excel::download(new class($exportData, $headers) implements \Maatwebsite\Excel\Concerns\FromArray {
                private $data;
                private $headers;

                public function __construct($data, $headers)
                {
                    $this->data = $data;
                    $this->headers = $headers;
                }

                public function array(): array
                {
                    return array_merge([$this->headers], $this->data);
                }
            }, $fileName);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while downloading records: ' . $e->getMessage());
        }
    }
}