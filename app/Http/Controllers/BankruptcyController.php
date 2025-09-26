<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bankruptcy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BankruptcyImport;
use Illuminate\Support\Facades\Storage;

class BankruptcyController extends Controller
{
    /**
     * Display the upload form
     */
    public function create()
    {
        return view('bankruptcy.create');
    }

    /**
     * Store bankruptcy data
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'insolvency_no' => 'required|string|unique:bankruptcies,insolvency_no',
            'name' => 'required|string|max:255',
            'ic_no' => 'required|string|max:20',
            'others' => 'nullable|string',
            'court_case_no' => 'nullable|string',
            'ro_date' => 'nullable|date',
            'ao_date' => 'nullable|date',
            'updated_date' => 'nullable|date',
            'branch' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $bankruptcy = Bankruptcy::create($request->all());

            return redirect()->route('bankruptcy.index')
                ->with('success', 'Bankruptcy data uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while uploading data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display a listing of bankruptcies
     */
    public function index()
    {
        $bankruptcies = Bankruptcy::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('bankruptcy.index', compact('bankruptcies'));
    }

    /**
     * Display the specified bankruptcy
     */
    public function show(Bankruptcy $bankruptcy)
    {
        return view('bankruptcy.show', compact('bankruptcy'));
    }

    /**
     * Show the form for editing the specified bankruptcy
     */
    public function edit(Bankruptcy $bankruptcy)
    {
        return view('bankruptcy.edit', compact('bankruptcy'));
    }

    /**
     * Update the specified bankruptcy
     */
    public function update(Request $request, Bankruptcy $bankruptcy)
    {
        $validator = Validator::make($request->all(), [
            'insolvency_no' => 'required|string|unique:bankruptcies,insolvency_no,' . $bankruptcy->id,
            'name' => 'required|string|max:255',
            'ic_no' => 'required|string|max:20',
            'others' => 'nullable|string',
            'court_case_no' => 'nullable|string',
            'ro_date' => 'nullable|date',
            'ao_date' => 'nullable|date',
            'updated_date' => 'nullable|date',
            'branch' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $bankruptcy->update($request->all());

            return redirect()->route('bankruptcy.show', $bankruptcy)
                ->with('success', 'Bankruptcy data updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified bankruptcy (soft delete)
     */
    public function destroy(Bankruptcy $bankruptcy)
    {
        try {
            $bankruptcy->update(['is_active' => false]);

            return redirect()->route('bankruptcy.index')
                ->with('success', 'Bankruptcy record deactivated successfully!');
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
        return view('bankruptcy.bulk-upload');
    }

    /**
     * Process bulk upload from Excel file
     */
    public function processBulkUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('excel_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store file temporarily
            $file->storeAs('temp', $fileName);
            $filePath = storage_path('app/temp/' . $fileName);

            // Import data
            $import = new BankruptcyImport();
            Excel::import($import, $filePath);

            // Clean up temp file
            Storage::delete('temp/' . $fileName);

            $importedCount = $import->getRowCount();
            $skippedDuplicates = $import->getSkippedDuplicates();
            
            $message = "Successfully imported {$importedCount} bankruptcy records.";
            if ($skippedDuplicates > 0) {
                $message .= " {$skippedDuplicates} duplicate IC numbers were skipped.";
            }

            // Initialize empty arrays for errors and failures
            $errorsArray = [];
            $failuresArray = [];

            return redirect()->route('bankruptcy.index')
                ->with('success', $message)
                ->with('import_errors', $errorsArray)
                ->with('import_failures', $failuresArray)
                ->with('debug_info', [
                    'imported_count' => $importedCount,
                    'skipped_duplicates' => $skippedDuplicates,
                    'error_count' => count($errorsArray),
                    'failure_count' => count($failuresArray),
                    'first_few_failures' => array_slice($failuresArray, 0, 3)
                ]);

        } catch (\Exception $e) {
            // Clean up temp file if it exists
            if (isset($fileName) && Storage::exists('temp/' . $fileName)) {
                Storage::delete('temp/' . $fileName);
            }

            return redirect()->back()
                ->with('error', 'An error occurred during bulk upload: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Test import with sample data
     */
    public function testImport()
    {
        try {
            // Create test data
            $testData = [
                ['insolvency_no', 'name', 'ic_no', 'others', 'court_case_no', 'ro_date', 'ao_date', 'updated_date', 'branch'],
                ['INS001', 'John Doe', '123456789012', 'Test data', 'CASE001', '2024-01-01', '2024-06-01', '2024-09-25', 'KL Branch'],
                ['INS002', 'Jane Smith', '987654321098', 'Another test', 'CASE002', '2024-02-01', '2024-07-01', '2024-09-25', 'JB Branch']
            ];
            
            // Create temporary Excel file
            $fileName = 'test_bankruptcy_' . time() . '.xlsx';
            $filePath = storage_path('app/temp/' . $fileName);
            
            // Ensure temp directory exists
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }
            
            // Create Excel file
            $excel = new \Maatwebsite\Excel\Excel();
            $excel->store(new class($testData) implements \Maatwebsite\Excel\Concerns\FromArray {
                private $data;
                
                public function __construct($data) {
                    $this->data = $data;
                }
                
                public function array(): array {
                    return $this->data;
                }
            }, 'temp/' . $fileName);
            
            // Test import
            $import = new \App\Imports\BankruptcyImport();
            Excel::import($import, $filePath);
            
            // Clean up
            Storage::delete('temp/' . $fileName);
            
            $importedCount = $import->getRowCount();
            
            return response()->json([
                'success' => true,
                'message' => "Test import completed successfully! Imported {$importedCount} records.",
                'imported_count' => $importedCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Debug import process
     */
    public function debugImport(Request $request)
    {
        if (!$request->hasFile('excel_file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        try {
            $file = $request->file('excel_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store file temporarily
            $file->storeAs('temp', $fileName);
            $filePath = storage_path('app/temp/' . $fileName);

            // Read first few rows to see structure
            $reader = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\BankruptcyImport(), $filePath);
            
            // Clean up temp file
            Storage::delete('temp/' . $fileName);

            return response()->json([
                'success' => true,
                'total_rows' => count($reader[0]),
                'headers' => array_keys($reader[0][0] ?? []),
                'first_row' => $reader[0][0] ?? [],
                'sample_rows' => array_slice($reader[0], 0, 3)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download Excel template
     */
    public function downloadTemplate()
    {
        $templateData = [
            [
                'insolvency_no' => 'INS001',
                'name' => 'John Doe',
                'ic_no' => '123456789012',
                'others' => 'Additional information',
                'court_case_no' => 'CASE2024001',
                'ro_date' => '2024-01-15',
                'ao_date' => '2024-06-15',
                'updated_date' => '2024-09-25',
                'branch' => 'Kuala Lumpur Branch'
            ]
        ];

        $headers = [
            'insolvency_no', 'name', 'ic_no', 'others', 'court_case_no',
            'ro_date', 'ao_date', 'updated_date', 'branch'
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
        }, 'bankruptcy_template.xlsx');
    }
}
