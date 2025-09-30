<?php

namespace App\Http\Controllers;

use App\Models\AnnulmentIndv;
use App\Imports\AnnulmentIndvImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class AnnulmentIndvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annulmentIndv = AnnulmentIndv::active()->orderBy('name')->get();
        return view('annulment-indv.index', compact('annulmentIndv'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('annulment-indv.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ic_no' => 'required|string|max:20|unique:annulment_indv,ic_no',
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'updated_date' => 'nullable|string',
            'release_type' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
        ]);

        AnnulmentIndv::create($request->all());

        return redirect()->route('annulment-indv.index')
            ->with('success', 'Annulment record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnulmentIndv $annulmentIndv)
    {
        return view('annulment-indv.show', compact('annulmentIndv'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnnulmentIndv $annulmentIndv)
    {
        return view('annulment-indv.edit', compact('annulmentIndv'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnnulmentIndv $annulmentIndv)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ic_no' => 'required|string|max:20|unique:annulment_indv,ic_no,' . $annulmentIndv->id,
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'updated_date' => 'nullable|string',
            'release_type' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
        ]);

        $annulmentIndv->update($request->all());

        return redirect()->route('annulment-indv.index')
            ->with('success', 'Annulment record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnulmentIndv $annulmentIndv)
    {
        $annulmentIndv->delete();

        return redirect()->route('annulment-indv.index')
            ->with('success', 'Annulment record deleted successfully.');
    }

    /**
     * Show bulk upload form
     */
    public function bulkUpload()
    {
        try {
            return view('annulment-indv.bulk-upload-simple');
        } catch (\Exception $e) {
            Log::error('Bulk upload view error: ' . $e->getMessage());
            return redirect()->route('annulment-indv.index')
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

            $import = new AnnulmentIndvImport();
            
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

                return redirect()->route('annulment-indv.index')
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
            $import = new AnnulmentIndvImport();
            
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
                    for ($col = 'A'; $col <= 'H'; $col++) {
                        $rowData[] = $worksheet->getCell($col . $row)->getValue();
                    }
                    
                    $mappedData = $import->mapRowData($rowData);
                    $errors = $import->validateRow($mappedData);
                    
                    if (empty($errors)) {
                        try {
                            AnnulmentIndv::create($mappedData);
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
            
            return redirect()->route('annulment-indv.index')
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
            'Nama',
            'No. K/P Baru', 
            'No. Lain',
            'No. Kes Mahkamah',
            'Tarikh Pelepasan',
            'Tarikh Kemaskini',
            'Jenis Pelepasan',
            'Nama Cawangan'
        ];

        $filename = 'annulment_indv_template_' . date('Y-m-d') . '.xlsx';
        
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
        $annulmentIndv = AnnulmentIndv::active()->orderBy('name')->get();
        
        $filename = 'annulment_indv_records_' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new class($annulmentIndv) implements \Maatwebsite\Excel\Concerns\FromCollection {
            private $records;
            
            public function __construct($records) {
                $this->records = $records;
            }
            
            public function collection() {
                return $this->records->map(function ($record) {
                    return [
                        'Nama' => $record->name,
                        'No. K/P Baru' => $record->ic_no,
                        'No. Lain' => $record->others,
                        'No. Kes Mahkamah' => $record->court_case_no,
                        'Tarikh Pelepasan' => $record->release_date ? $record->release_date->format('d/m/Y') : '',
                        'Tarikh Kemaskini' => $record->formatted_updated_date,
                        'Jenis Pelepasan' => $record->release_type,
                        'Nama Cawangan' => $record->branch,
                    ];
                });
            }
        }, $filename);
    }
}