<?php

namespace App\Imports;

use App\Models\Bankruptcy;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class BankruptcyImport implements ToCollection
{
    private $rowCount = 0;
    private $skippedDuplicates = 0;
    private $processedIcNumbers = [];

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            // Skip the first row (header row)
            if ($index === 0) {
                continue;
            }
            
            try {
                $this->rowCount++;
                
                // Log the row data for debugging (only first few rows to avoid spam)
                if ($this->rowCount <= 3) {
                    $rowData = is_array($row) ? $row : $row->toArray();
                    Log::info('Processing row ' . $this->rowCount . ':', $rowData);
                }
                
                // Map different possible column names to our expected names
                $rowData = is_array($row) ? $row : $row->toArray();
                $mappedRow = $this->mapRowData($rowData);
                
                // Manual validation
                $validationErrors = $this->validateRow($mappedRow);
                if (!empty($validationErrors)) {
                    Log::warning('Validation failed for row ' . $this->rowCount . ': ' . implode(', ', $validationErrors), [
                        'original_row' => $rowData,
                        'mapped_row' => $mappedRow,
                        'errors' => $validationErrors
                    ]);
                    continue;
                }
                
                // Check for duplicate ic_no in database
                $existingRecord = Bankruptcy::where('ic_no', $mappedRow['ic_no'])->first();
                if ($existingRecord) {
                    $this->skippedDuplicates++;
                    Log::info('Duplicate ic_no found in database: ' . $mappedRow['ic_no'] . ' - skipping row ' . $this->rowCount);
                    continue; // Skip duplicate records
                }
                
                // Check for duplicate ic_no within current import batch
                if (in_array($mappedRow['ic_no'], $this->processedIcNumbers)) {
                    $this->skippedDuplicates++;
                    Log::info('Duplicate ic_no found in current batch: ' . $mappedRow['ic_no'] . ' - skipping row ' . $this->rowCount);
                    continue; // Skip duplicate records
                }
                
                // Add to processed IC numbers
                $this->processedIcNumbers[] = $mappedRow['ic_no'];
                
                // Create and save the record
                Bankruptcy::create([
                    'insolvency_no' => $mappedRow['insolvency_no'],
                    'name' => $mappedRow['name'],
                    'ic_no' => $mappedRow['ic_no'],
                    'others' => $mappedRow['others'] ?? null,
                    'court_case_no' => $mappedRow['court_case_no'] ?? null,
                    'ro_date' => $mappedRow['ro_date'] ?? null,
                    'ao_date' => $mappedRow['ao_date'] ?? null,
                    'updated_date' => $mappedRow['updated_date'] ?? null,
                    'branch' => $mappedRow['branch'] ?? null,
                    'is_active' => true,
                ]);
                
            } catch (\Exception $e) {
                $rowData = is_array($row) ? $row : $row->toArray();
                Log::error('Error importing bankruptcy row ' . $this->rowCount . ': ' . $e->getMessage(), ['row' => $rowData]);
                continue;
            }
        }
    }

    /**
     * Map different possible column names to our expected names
     */
    public function mapRowData(array $row): array
    {
        $mapped = [];
        
        // Map insolvency_no (prioritize numeric columns)
        $insolvencyNo = $row[0] ?? // Numeric column header - PRIORITY
                       $row['insolvency_no'] ?? 
                       $row['bankruptcy_id'] ?? 
                       $row['insolvency_number'] ?? 
                       $row['no_involvency'] ?? null;
        $mapped['insolvency_no'] = $insolvencyNo ? (string) $insolvencyNo : null;
        
        // Map name (prioritize numeric columns)
        $mapped['name'] = $row[1] ?? // Numeric column header - PRIORITY
                         $row['name'] ?? 
                         $row['full_name'] ?? 
                         $row['person_name'] ?? null;
        
        // Map ic_no (prioritize numeric columns)
        $icNo = $row[2] ?? // Numeric column header - PRIORITY
                $row['ic_no'] ?? 
                $row['ic_number'] ?? 
                $row['ic'] ?? 
                $row['identity_card'] ?? null;
        $mapped['ic_no'] = $icNo ? (string) $icNo : null;
        
        // Map others (prioritize numeric columns)
        $mapped['others'] = $row[3] ?? // Numeric column header - PRIORITY
                           $row['others'] ?? 
                           $row['additional_info'] ?? 
                           $row['remarks'] ?? 
                           $row['notes'] ?? null;
        
        // Map court_case_no (prioritize numeric columns)
        $mapped['court_case_no'] = $row[4] ?? // Numeric column header - PRIORITY
                                  $row['court_case_no'] ?? 
                                  $row['case_number'] ?? 
                                  $row['court_case_number'] ?? null;
        
        // Map ro_date and convert Excel serial number to date (prioritize numeric columns)
        $roDate = $row[5] ?? // Numeric column header - PRIORITY
                 $row['ro_date'] ?? 
                 $row['ro'] ?? 
                 $row['receiving_order_date'] ?? null;
        $mapped['ro_date'] = $this->convertExcelDate($roDate);
        
        // Map ao_date and convert Excel serial number to date (prioritize numeric columns)
        $aoDate = $row[6] ?? // Numeric column header - PRIORITY
                 $row['ao_date'] ?? 
                 $row['ao'] ?? 
                 $row['annulment_order_date'] ?? null;
        $mapped['ao_date'] = $this->convertExcelDate($aoDate);
        
        // Map updated_date and convert Excel serial number to date (prioritize numeric columns)
        $updatedDate = $row[7] ?? // Numeric column header - PRIORITY
                      $row['updated_date'] ?? 
                      $row['last_updated'] ?? 
                      $row['modified_date'] ?? null;
        $mapped['updated_date'] = $this->convertExcelDate($updatedDate);
        
        // Map branch (prioritize numeric columns)
        $mapped['branch'] = $row[8] ?? // Numeric column header - PRIORITY
                           $row['branch'] ?? 
                           $row['branch_name'] ?? 
                           $row['office'] ?? null;
        
        return $mapped;
    }

    /**
     * Convert Excel serial number to date string
     */
    public function convertExcelDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }
        
        // If it's already a string date, return as is
        if (is_string($value) && strtotime($value)) {
            return $value;
        }
        
        // If it's a numeric value (Excel serial number), convert it
        if (is_numeric($value)) {
            try {
                // Use PhpSpreadsheet's Excel date conversion
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
                return $date->format('Y-m-d');
            } catch (\Exception $e) {
                // Fallback to manual conversion if PhpSpreadsheet fails
                $excelEpoch = mktime(0, 0, 0, 1, 1, 1900);
                $timestamp = $excelEpoch + (intval($value) - 2) * 86400; // 86400 seconds in a day
                
                // Handle the Excel bug for dates before March 1, 1900
                if ($value < 60) {
                    $timestamp = $excelEpoch + (intval($value) - 1) * 86400;
                }
                
                return date('Y-m-d', $timestamp);
            }
        }
        
        return null;
    }

    /**
     * Manual validation in model method
     */
    public function validateRow(array $row): array
    {
        $errors = [];
        
        if (empty($row['insolvency_no'])) {
            $errors[] = 'Insolvency number is required';
        }
        
        if (empty($row['name'])) {
            $errors[] = 'Name is required';
        }
        
        if (empty($row['ic_no'])) {
            $errors[] = 'IC number is required';
        }
        
        // Validate dates if provided
        if (!empty($row['ro_date']) && !strtotime($row['ro_date'])) {
            $errors[] = 'RO date must be a valid date';
        }
        
        if (!empty($row['ao_date']) && !strtotime($row['ao_date'])) {
            $errors[] = 'AO date must be a valid date';
        }
        
        if (!empty($row['updated_date']) && !strtotime($row['updated_date'])) {
            $errors[] = 'Updated date must be a valid date';
        }
        
        return $errors;
    }



    /**
     * Get the number of rows processed
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    /**
     * Get the number of skipped duplicates
     * @return int
     */
    public function getSkippedDuplicates(): int
    {
        return $this->skippedDuplicates;
    }

}
