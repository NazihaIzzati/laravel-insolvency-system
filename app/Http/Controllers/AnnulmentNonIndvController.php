<?php

namespace App\Http\Controllers;

use App\Models\AnnulmentNonIndv;
use App\Imports\AnnulmentNonIndvImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class AnnulmentNonIndvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Default to 10 records per page
        
        // Validate per_page parameter
        $allowedPerPage = [5, 10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }
        
        $annulmentNonIndv = AnnulmentNonIndv::active()
            ->orderBy('company_name')
            ->paginate($perPage)
            ->withQueryString(); // Preserve query parameters in pagination links
            
        return view('annulment-non-indv.index', compact('annulmentNonIndv', 'perPage'));
    }

    /**
     * Search annulment records
     */
    public function search(Request $request)
    {
        try {
            $request->validate([
                'search_input' => 'required|string'
            ]);

            $searchValue = $request->input('search_input');
            
            if (empty($searchValue)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a search value.'
                ]);
            }

            $results = AnnulmentNonIndv::where('is_active', true)
                ->where(function($query) use ($searchValue) {
                    $query->where('insolvency_no', 'LIKE', "%{$searchValue}%")
                          ->orWhere('company_name', 'LIKE', "%{$searchValue}%")
                          ->orWhere('company_registration_no', 'LIKE', "%{$searchValue}%")
                          ->orWhere('court_case_no', 'LIKE', "%{$searchValue}%")
                          ->orWhere('others', 'LIKE', "%{$searchValue}%");
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'results' => $results
            ]);

        } catch (\Exception $e) {
            \Log::error('Annulment non-indv search error:', [
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('annulment-non-indv.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'insolvency_no' => 'required|string|max:255|unique:annulment_non_indv,insolvency_no',
            'company_name' => 'required|string|max:255',
            'company_registration_no' => 'required|string|max:255',
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'updated_date' => 'nullable|string',
            'release_type' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
        ]);

        AnnulmentNonIndv::create($request->all());

        return redirect()->route('annulment-non-indv.index')
            ->with('success', 'Annulment record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnulmentNonIndv $annulmentNonIndv)
    {
        return view('annulment-non-indv.show', compact('annulmentNonIndv'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnnulmentNonIndv $annulmentNonIndv)
    {
        return view('annulment-non-indv.edit', compact('annulmentNonIndv'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnnulmentNonIndv $annulmentNonIndv)
    {
        $request->validate([
            'insolvency_no' => 'required|string|max:255|unique:annulment_non_indv,insolvency_no,' . $annulmentNonIndv->id,
            'company_name' => 'required|string|max:255',
            'company_registration_no' => 'required|string|max:255',
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'updated_date' => 'nullable|string',
            'release_type' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
        ]);

        $annulmentNonIndv->update($request->all());

        return redirect()->route('annulment-non-indv.index')
            ->with('success', 'Annulment record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnulmentNonIndv $annulmentNonIndv)
    {
        $annulmentNonIndv->delete();

        return redirect()->route('annulment-non-indv.index')
            ->with('success', 'Annulment record deleted successfully.');
    }

    /**
     * Show bulk upload form
     */
    public function bulkUpload()
    {
        try {
            return view('annulment-non-indv.bulk-upload-simple');
        } catch (\Exception $e) {
            Log::error('Bulk upload view error: ' . $e->getMessage());
            return redirect()->route('annulment-non-indv.index')
                ->with('error', 'Error loading bulk upload page: ' . $e->getMessage());
        }
    }

    /**
     * Process bulk upload
     */
    public function processBulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:51200', // 50MB max for large files
        ]);

        try {
            // Increase memory limit for large files
            ini_set('memory_limit', '1024M'); // Increased to 1GB
            ini_set('max_execution_time', 600); // Increased to 10 minutes

            $import = new AnnulmentNonIndvImport();
            
            // Use queue for files larger than 5MB to avoid memory issues
            $fileSize = $request->file('file')->getSize();
            if ($fileSize > 5 * 1024 * 1024) { // If file is larger than 5MB
                // Process large file manually to avoid memory issues
                return $this->processLargeFile($request->file('file'));
            } else {
                Excel::import($import, $request->file('file'));

                $rowCount = $import->getRowCount();
                $skippedDuplicates = $import->getSkippedDuplicates();

                $message = "Successfully imported {$rowCount} annulment records.";
                if ($skippedDuplicates > 0) {
                    $message .= " {$skippedDuplicates} duplicate records were skipped.";
                }

                return redirect()->route('annulment-non-indv.index')
                    ->with('success', $message);
            }

        } catch (\Exception $e) {
            Log::error('Bulk upload error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Error importing file: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Process large files manually to avoid memory issues
     */
    private function processLargeFile($file)
    {
        try {
            $import = new AnnulmentNonIndvImport();
            
            // Process the file in smaller chunks
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $reader->setReadEmptyCells(false);
            
            $spreadsheet = $reader->load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            
            $processed = 0;
            $skipped = 0;
            $chunkSize = 500; // Process 500 rows at a time
            
            for ($startRow = 2; $startRow <= $highestRow; $startRow += $chunkSize) {
                $endRow = min($startRow + $chunkSize - 1, $highestRow);
                
                for ($row = $startRow; $row <= $endRow; $row++) {
                    $rowData = [];
                    for ($col = 'A'; $col <= 'I'; $col++) {
                        $rowData[] = $worksheet->getCell($col . $row)->getValue();
                    }
                    
                    $mappedData = $import->mapRowData($rowData);
                    $errors = $import->validateRow($mappedData);
                    
                    if (empty($errors)) {
                        try {
                            AnnulmentNonIndv::create($mappedData);
                            $processed++;
                        } catch (\Exception $e) {
                            $skipped++;
                            Log::warning('Skipped duplicate record: ' . $e->getMessage());
                        }
                    } else {
                        $skipped++;
                    }
                }
                
                // Force garbage collection every chunk
                gc_collect_cycles();
            }
            
            $message = "Successfully imported {$processed} annulment records.";
            if ($skipped > 0) {
                $message .= " {$skipped} records were skipped.";
            }
            
            return redirect()->route('annulment-non-indv.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            Log::error('Large file processing error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error processing large file: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Download Excel template
     */
    public function downloadTemplate()
    {
        $headers = [
            'Company Name',
            'Company Registration No', 
            'Others',
            'Court Case No',
            'Date Update',
            'Release type',
            'Stay Order Date',
            'Branch'
        ];

        $filename = 'annulment_non_indv_template_' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray {
            private $headers;
            
            public function __construct($headers) {
                $this->headers = $headers;
            }
            
            public function array(): array {
                return [$this->headers];
            }
        }, $filename);
    }

    /**
     * Download all records as Excel
     */
    public function downloadRecords()
    {
        $annulmentNonIndv = AnnulmentNonIndv::active()->orderBy('company_name')->get();
        
        $filename = 'annulment_non_indv_records_' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new class($annulmentNonIndv) implements \Maatwebsite\Excel\Concerns\FromCollection {
            private $records;
            
            public function __construct($records) {
                $this->records = $records;
            }
            
            public function collection() {
                return $this->records->map(function ($record) {
                    return [
                        'Company Name' => $record->company_name,
                        'Company Registration No' => $record->company_registration_no,
                        'Others' => $record->others,
                        'Court Case No' => $record->court_case_no,
                        'Date Update' => $record->formatted_updated_date,
                        'Release type' => $record->release_type,
                        'Stay Order Date' => $record->release_date ? $record->release_date->format('d/m/Y') : '',
                        'Branch' => $record->branch,
                    ];
                });
            }
        }, $filename);
    }
}
