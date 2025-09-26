<?php

namespace App\Imports;

use App\Models\NonIndividualBankruptcy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NonIndividualBankruptcyImport implements ToCollection, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    private $rowCount = 0;
    private $skippedDuplicates = 0;

    public function collection(Collection $rows)
    {
        \Log::info('=== IMPORT START ===', [
            'total_rows' => $rows->count(),
            'timestamp' => now()->toDateTimeString()
        ]);
        
        foreach ($rows as $index => $row) {
            // Skip the first row (header row)
            if ($index === 0) {
                continue;
            }
            
            try {
                // Debug: Log raw row data for first few rows
                if ($index < 4) {
                    \Log::info('Raw row data for row ' . $index, [
                        'row_data' => $row->toArray(),
                        'available_keys' => array_keys($row->toArray())
                    ]);
                }
                
                $updatedDate = $this->parseDate(
                    $row[6] ??  // Numeric column header for Updated Date (Excel serial date) - PRIORITY
                    $row['Updated Date'] ?? 
                    $row['updated_date'] ?? 
                    $row['AO Date'] ??  // Individual bankruptcy column name
                    $row[7] ??  // Alternative column for Updated Date
                    $row[8] ??  // Alternative column for Updated Date
                    $row['updated_at'] ?? 
                    null
                );
                
                $windingUpDate = $this->parseDate(
                    $row[5] ??  // Numeric column header for Date of Winding Up/Resolution (Excel serial date) - PRIORITY
                    $row['Date of Winding Up/Resolution'] ?? 
                    $row['date_of_winding_up_resolution'] ?? 
                    $row['ro_date'] ??  // Individual bankruptcy column name
                    $row[6] ??  // Alternative column for RO Date
                    $row['date_of_winding_up'] ?? 
                    $row['winding_up_date'] ?? 
                    null
                );
                
                // Debug: Log date parsing results for first few rows
                if ($index < 4) {
                    \Log::info('Date parsing results for row ' . $index, [
                        'Date_of_Winding_Up_Resolution_raw' => $row[5] ?? 'not found',
                        'Date_of_Winding_Up_Resolution_parsed' => $windingUpDate,
                        'Updated_Date_raw' => $row[6] ?? 'not found',
                        'Updated_Date_parsed' => $updatedDate
                    ]);
                }

                // Get registration number with fallback for different column formats
                $registrationNo = $row[2] ?? // Numeric column header for registration number - PRIORITY
                                 $row['Company Registration No'] ?? 
                                 $row['company_registration_no'] ?? 
                                 $row['Ic No'] ?? 
                                 null;
                if (empty($registrationNo)) {
                    $registrationNo = 'UNKNOWN_' . ($index + 1); // Unique identifier for unknown registration numbers
                }
                
                $data = [
                    'insolvency_no' => $row[0] ?? $row['Insolvency No'] ?? $row['insolvency_no'] ?? null,
                    'company_name' => $row[1] ?? $row['Company Name'] ?? $row['company_name'] ?? $row['Name'] ?? 'Unknown Company',
                    'company_registration_no' => $registrationNo,
                    'others' => !empty($row[3]) ? $row[3] : (!empty($row['Others']) ? $row['Others'] : ($row['others'] ?? null)),
                    'court_case_no' => !empty($row[4]) ? $row[4] : (!empty($row['Court Case No']) ? $row['Court Case No'] : ($row['court_case_no'] ?? null)),
                    'date_of_winding_up_resolution' => $windingUpDate,
                    'updated_date' => $updatedDate,
                    'branch' => !empty($row[7]) ? $row[7] : (!empty($row['Branch']) ? $row['Branch'] : ($row['branch'] ?? null)),
                    'is_active' => true,
                ];
                
                // Debug: Log the data being created for first few rows
                if ($index < 4) {
                    \Log::info('Data being created for row ' . $index, [
                        'data' => $data,
                        'raw_company_name' => $row[1] ?? 'not found',
                        'raw_company_registration_no' => $row[2] ?? 'not found',
                        'date_of_winding_up_resolution_raw' => $row[5] ?? 'not found',
                        'date_of_winding_up_resolution_final' => $data['date_of_winding_up_resolution'],
                        'updated_date_raw' => $row[6] ?? 'not found',
                        'updated_date_final' => $data['updated_date']
                    ]);
                }

                // Check if record exists by company_registration_no
                $existingRecord = NonIndividualBankruptcy::where('company_registration_no', $registrationNo)->first();
                
                if ($existingRecord) {
                    // Update existing record
                    $oldDate = $existingRecord->date_of_winding_up_resolution;
                    $oldUpdatedDate = $existingRecord->updated_date;
                    
                    $existingRecord->update($data);
                    $existingRecord->refresh();
                    
                    $this->skippedDuplicates++; // Count as updated
                    \Log::info('Updated existing record', [
                        'row' => $index,
                        'company_registration_no' => $registrationNo,
                        'old_date_of_winding_up_resolution' => $oldDate,
                        'new_date_of_winding_up_resolution' => $existingRecord->date_of_winding_up_resolution,
                        'old_updated_date' => $oldUpdatedDate,
                        'new_updated_date' => $existingRecord->updated_date
                    ]);
                } else {
                    // Create new record
                    NonIndividualBankruptcy::create($data);
                    $this->rowCount++;
                    \Log::info('Created new record', [
                        'row' => $index,
                        'company_registration_no' => $registrationNo,
                        'date_of_winding_up_resolution' => $data['date_of_winding_up_resolution'],
                        'updated_date' => $data['updated_date']
                    ]);
                }
            } catch (\Exception $e) {
                throw $e;
            }
        }
        
        \Log::info('=== IMPORT COMPLETED ===', [
            'new_records' => $this->rowCount,
            'updated_records' => $this->skippedDuplicates,
            'total_processed' => $this->rowCount + $this->skippedDuplicates,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Parse date from various formats
     */
    private function parseDate($dateValue)
    {
        if (empty($dateValue) || $dateValue === null || $dateValue === '' || strtolower(trim($dateValue)) === 'n/a') {
            return null;
        }

        try {
            // Handle different date formats
            if (is_numeric($dateValue)) {
                // Excel serial date
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue);
                return $date->format('Y-m-d');
            } else {
                // Clean the date string
                $dateString = trim($dateValue);
                
                // Try different date formats
                $formats = [
                    'Y-m-d',           // 2025-01-15
                    'd/m/Y',           // 15/01/2025
                    'd-m-Y',           // 15-01-2025
                    'd.m.Y',           // 15.01.2025
                    'Y/m/d',           // 2025/01/15
                    'd/m/y',           // 15/01/25
                    'd-m-y',           // 15-01-25
                    'd/m/Y H:i',       // 23/07/2025 10:44
                    'd/m/Y H:i:s',     // 23/07/2025 10:44:30
                    'M d, Y',          // Jan 15, 2025
                    'F d, Y',          // January 15, 2025
                    'd M Y',           // 15 Jan 2025
                    'd F Y',           // 15 January 2025
                ];
                
                foreach ($formats as $format) {
                    try {
                        $date = \Carbon\Carbon::createFromFormat($format, $dateString);
                        if ($date) {
                            return $date->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        // Continue to next format
                        continue;
                    }
                }
                
                // If no format worked, try Carbon's parse method
                $date = \Carbon\Carbon::parse($dateString);
                return $date->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getSkippedDuplicates(): int
    {
        return $this->skippedDuplicates;
    }
}
