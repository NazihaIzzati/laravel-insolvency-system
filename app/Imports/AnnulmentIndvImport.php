<?php

namespace App\Imports;

use App\Models\AnnulmentIndv;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AnnulmentIndvImport implements ToCollection, WithChunkReading, WithBatchInserts
{
    private $rowCount = 0;
    private $skippedDuplicates = 0;
    private $processedIcNumbers = [];
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
                    Log::info('Processing annulment row ' . $this->rowCount . ':', $rowData);
                }
                
                // Map different possible column names to our expected names
                $rowData = is_array($row) ? $row : $row->toArray();
                $mappedRow = $this->mapRowData($rowData);
                
                // Manual validation
                $validationErrors = $this->validateRow($mappedRow);
                if (!empty($validationErrors)) {
                    Log::warning('Validation failed for annulment row ' . $this->rowCount . ': ' . implode(', ', $validationErrors), [
                        'original_row' => $rowData,
                        'mapped_row' => $mappedRow,
                        'errors' => $validationErrors
                    ]);
                    continue;
                }
                
                // Check for duplicate ic_no in database
                $existingRecord = AnnulmentIndv::where('ic_no', $mappedRow['ic_no'])->first();
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
                
                // Add to processed IC numbers (limit to prevent memory issues)
                $this->processedIcNumbers[] = $mappedRow['ic_no'];
                
                // Clear processed IC numbers array periodically to prevent memory issues
                if (count($this->processedIcNumbers) > 10000) {
                    $this->processedIcNumbers = array_slice($this->processedIcNumbers, -5000);
                }
                
                // Force garbage collection every 1000 records to free memory
                if ($this->rowCount % 1000 === 0) {
                    gc_collect_cycles();
                }
                
                // Create and save the record
                AnnulmentIndv::create([
                    'name' => $mappedRow['name'],
                    'ic_no' => $mappedRow['ic_no'],
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
                Log::error('Error importing annulment row ' . $this->rowCount . ': ' . $e->getMessage(), ['row' => $rowData]);
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
        
        // Map name (prioritize numeric columns)
        $mapped['name'] = $row[0] ?? // Numeric column header - PRIORITY
                         $row['nama'] ?? 
                         $row['name'] ?? 
                         $row['full_name'] ?? 
                         $row['person_name'] ?? null;
        
        // Map ic_no (prioritize numeric columns)
        $icNo = $row[1] ?? // Numeric column header - PRIORITY
                $row['no_kp_baru'] ?? 
                $row['ic_no'] ?? 
                $row['ic_number'] ?? 
                $row['ic'] ?? 
                $row['identity_card'] ?? null;
        $mapped['ic_no'] = $icNo ? (string) $icNo : null;
        
        // Map others (prioritize numeric columns)
        $mapped['others'] = $row[2] ?? // Numeric column header - PRIORITY
                           $row['no_lain'] ?? 
                           $row['others'] ?? 
                           $row['additional_info'] ?? 
                           $row['remarks'] ?? 
                           $row['notes'] ?? null;
        
        // Map court_case_no (prioritize numeric columns)
        $mapped['court_case_no'] = $row[3] ?? // Numeric column header - PRIORITY
                                  $row['no_kes_mahkamah'] ?? 
                                  $row['court_case_no'] ?? 
                                  $row['case_number'] ?? 
                                  $row['court_case_number'] ?? null;
        
        // Map release_date and convert Excel serial number to date (prioritize numeric columns)
        $releaseDate = $row[4] ?? // Numeric column header - PRIORITY
                      $row['tarikh_pelepasan'] ?? 
                      $row['release_date'] ?? 
                      $row['release'] ?? null;
        $mapped['release_date'] = $this->convertExcelDate($releaseDate);
        
        // Map updated_date and convert Excel serial number to date (prioritize numeric columns)
        $updatedDate = $row[5] ?? // Numeric column header - PRIORITY
                      $row['tarikh_kemaskini'] ?? 
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
        
        // Map release_type (prioritize numeric columns)
        $mapped['release_type'] = $row[6] ?? // Numeric column header - PRIORITY
                                 $row['jenis_pelepasan'] ?? 
                                 $row['release_type'] ?? 
                                 $row['type'] ?? null;
        
        // Map branch (prioritize numeric columns)
        $mapped['branch'] = $row[7] ?? // Numeric column header - PRIORITY
                           $row['nama_cawangan'] ?? 
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
        
        if (empty($row['name'])) {
            $errors[] = 'Name is required';
        }
        
        if (empty($row['ic_no'])) {
            $errors[] = 'IC number is required';
        }
        
        // Validate dates if provided
        if (!empty($row['release_date']) && !strtotime($row['release_date'])) {
            $errors[] = 'Release date must be a valid date';
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
                $errors[] = 'Updated date must be a valid date';
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
