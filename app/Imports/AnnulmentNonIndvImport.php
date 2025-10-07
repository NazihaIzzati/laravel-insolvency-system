<?php

namespace App\Imports;

use App\Models\AnnulmentNonIndv;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AnnulmentNonIndvImport implements ToCollection, WithChunkReading, WithBatchInserts
{
    private $rowCount = 0;
    private $skippedDuplicates = 0;
    private $processedInsolvencyNumbers = [];
    private $batchData = [];

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
                    Log::info('Processing annulment non-indv row ' . $this->rowCount . ':', $rowData);
                }
                
                // Map different possible column names to our expected names
                $rowData = is_array($row) ? $row : $row->toArray();
                $mappedRow = $this->mapRowData($rowData);
                
                // Manual validation
                $validationErrors = $this->validateRow($mappedRow);
                if (!empty($validationErrors)) {
                    Log::warning('Validation failed for annulment non-indv row ' . $this->rowCount . ': ' . implode(', ', $validationErrors), [
                        'original_row' => $rowData,
                        'mapped_row' => $mappedRow,
                        'errors' => $validationErrors
                    ]);
                    continue;
                }
                
                // Check for duplicate insolvency_no in database
                $existingRecord = AnnulmentNonIndv::where('insolvency_no', $mappedRow['insolvency_no'])->first();
                if ($existingRecord) {
                    $this->skippedDuplicates++;
                    Log::info('Duplicate insolvency_no found in database: ' . $mappedRow['insolvency_no'] . ' - skipping row ' . $this->rowCount);
                    continue; // Skip duplicate records
                }
                
                // Check for duplicate insolvency_no within current import batch
                if (in_array($mappedRow['insolvency_no'], $this->processedInsolvencyNumbers)) {
                    $this->skippedDuplicates++;
                    Log::info('Duplicate insolvency_no found in current batch: ' . $mappedRow['insolvency_no'] . ' - skipping row ' . $this->rowCount);
                    continue; // Skip duplicate records
                }
                
                // Add to processed insolvency numbers (limit to prevent memory issues)
                $this->processedInsolvencyNumbers[] = $mappedRow['insolvency_no'];
                
                // Clear processed insolvency numbers array periodically to prevent memory issues
                if (count($this->processedInsolvencyNumbers) > 10000) {
                    $this->processedInsolvencyNumbers = array_slice($this->processedInsolvencyNumbers, -5000);
                }
                
                // Force garbage collection every 1000 records to free memory
                if ($this->rowCount % 1000 === 0) {
                    gc_collect_cycles();
                }
                
                // Create and save the record
                AnnulmentNonIndv::create([
                    'insolvency_no' => $mappedRow['insolvency_no'],
                    'company_name' => $mappedRow['company_name'],
                    'company_registration_no' => $mappedRow['company_registration_no'],
                    'others' => $mappedRow['others'] ?? null,
                    'court_case_no' => $mappedRow['court_case_no'] ?? null,
                    'release_date' => $mappedRow['release_date'] ?? null,
                    'updated_date' => $mappedRow['updated_date'] ?: now()->format('d/m/Y h:i A'), // Use current timestamp if not provided
                    'release_type' => $mappedRow['release_type'] ?? null,
                    'branch' => $mappedRow['branch'] ?? null,
                    'is_active' => true,
                ]);
                
            } catch (\Exception $e) {
                $rowData = is_array($row) ? $row : $row->toArray();
                Log::error('Error importing annulment non-indv row ' . $this->rowCount . ': ' . $e->getMessage(), ['row' => $rowData]);
                continue;
            }
        }
    }

    /**
     * Map different possible column names to our expected names
     * Updated to match the actual Excel structure from release_com_2025.xlsx
     */
    public function mapRowData(array $row): array
    {
        $mapped = [];
        
        // Generate insolvency_no from company registration number since it's not in Excel
        $companyRegNo = $row[1] ?? $row['company_registration_no'] ?? null;
        $mapped['insolvency_no'] = $companyRegNo ? 'NINS-' . $companyRegNo : null;
        
        // Map company_name (Column A)
        $mapped['company_name'] = $row[0] ?? // Column A - Company Name
                                  $row['company_name'] ?? 
                                  $row['company'] ?? 
                                  $row['business_name'] ?? null;
        
        // Map company_registration_no (Column B)
        $mapped['company_registration_no'] = $row[1] ?? // Column B - Company Registration No
                                             $row['company_registration_no'] ?? 
                                             $row['registration_no'] ?? 
                                             $row['company_reg_no'] ?? null;
        
        // Map others (Column C)
        $mapped['others'] = $row[2] ?? // Column C - Others
                           $row['others'] ?? 
                           $row['additional_info'] ?? 
                           $row['remarks'] ?? 
                           $row['notes'] ?? null;
        
        // Map court_case_no (Column D)
        $mapped['court_case_no'] = $row[3] ?? // Column D - Court Case No
                                  $row['court_case_no'] ?? 
                                  $row['case_number'] ?? 
                                  $row['court_case_number'] ?? null;
        
        // Map updated_date (Column E - Date Update) and convert Excel serial number to date
        $updatedDate = $row[4] ?? // Column E - Date Update
                      $row['date_update'] ?? 
                      $row['updated_date'] ?? 
                      $row['last_updated'] ?? 
                      $row['modified_date'] ?? null;
        
        if (!empty($updatedDate)) {
            // If it's already a datetime string (Y-m-d H:i:s), convert directly
            if (is_string($updatedDate) && preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $updatedDate)) {
                $mapped['updated_date'] = \Carbon\Carbon::parse($updatedDate)->format('d/m/Y h:i A');
            } else {
                // Try to convert Excel date
                $convertedDate = $this->convertExcelDate($updatedDate);
                if ($convertedDate) {
                    $mapped['updated_date'] = \Carbon\Carbon::parse($convertedDate)->format('d/m/Y h:i A');
                } else {
                    $mapped['updated_date'] = null;
                }
            }
        } else {
            $mapped['updated_date'] = null;
        }
        
        // Map release_type (Column F - Release type)
        $mapped['release_type'] = $row[5] ?? // Column F - Release type
                                 $row['release_type'] ?? 
                                 $row['type'] ?? null;
        
        // Map release_date (Column G - Stay Order Date) - using Stay Order Date as release date
        $stayOrderDate = $row[6] ?? // Column G - Stay Order Date
                        $row['stay_order_date'] ?? 
                        $row['release_date'] ?? 
                        $row['release'] ?? null;
        $mapped['release_date'] = $this->convertExcelDate($stayOrderDate);
        
        // Map branch (Column H - Branch)
        $mapped['branch'] = $row[7] ?? // Column H - Branch
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
        
        // Insolvency number is auto-generated, so we check if company registration number exists
        if (empty($row['company_registration_no'])) {
            $errors[] = 'Company registration number is required (used to generate insolvency number)';
        }
        
        if (empty($row['company_name'])) {
            $errors[] = 'Company name is required';
        }
        
        // Validate dates if provided
        if (!empty($row['release_date']) && !strtotime($row['release_date'])) {
            $errors[] = 'Stay Order Date must be a valid date';
        }
        
        if (!empty($row['updated_date'])) {
            // Check if it's a valid date format (either Y-m-d H:i:s or d/m/Y h:i A)
            $isValidDate = false;
            try {
                if (strpos($row['updated_date'], '/') !== false) {
                    // Format: d/m/Y h:i A
                    \Carbon\Carbon::createFromFormat('d/m/Y h:i A', $row['updated_date']);
                    $isValidDate = true;
                } else {
                    // Format: Y-m-d H:i:s
                    \Carbon\Carbon::parse($row['updated_date']);
                    $isValidDate = true;
                }
            } catch (\Exception $e) {
                $isValidDate = false;
            }
            
            if (!$isValidDate) {
                $errors[] = 'Date Update must be a valid date';
            }
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

    /**
     * Process data in chunks to avoid memory issues
     */
    public function chunkSize(): int
    {
        return 500; // Reduced from 1000 to 500 for better memory management
    }

    /**
     * Insert data in batches for better performance
     */
    public function batchSize(): int
    {
        return 500; // Reduced from 1000 to 500 for better memory management
    }
}
