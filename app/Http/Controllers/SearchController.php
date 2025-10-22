<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnulmentIndv;
use App\Models\AnnulmentNonIndv;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $request->validate([
                'search_input' => 'required|string'
            ]);

            $searchInput = trim($request->input('search_input'));

            $results = collect();

            // Auto-detect if input is IC number, company registration number, insolvency number, or court case number
            $isCompanyRegistration = $this->isCompanyRegistrationNumber($searchInput);
            $isICNumber = $this->isICNumber($searchInput);
            $isInsolvencyNumber = $this->isInsolvencyNumber($searchInput);
            $isCourtCaseNumber = $this->isCourtCaseNumber($searchInput);

            \Log::info('Search request received', [
                'search_input' => $searchInput,
                'all_input' => $request->all(),
                'is_insolvency_number' => $isInsolvencyNumber,
                'is_ic_number' => $isICNumber,
                'is_company_registration' => $isCompanyRegistration,
                'is_court_case_number' => $isCourtCaseNumber,
                'detection_priority' => 'Court Case > Insolvency > Company Registration > IC Number'
            ]);
            
            // Priority: Court Case Number > Insolvency Number > Company Registration > IC Number
            if ($isCourtCaseNumber) {
                $isInsolvencyNumber = false;
                $isCompanyRegistration = false;
                $isICNumber = false;
            } elseif ($isInsolvencyNumber) {
                $isCompanyRegistration = false;
                $isICNumber = false;
            } elseif ($isCompanyRegistration && $isICNumber) {
                $isICNumber = false; // Prioritize company registration number
            }

            // Search across all relevant tables based on input type
            if ($isCourtCaseNumber) {
                // Search all tables by court case number
                $bankruptcyResults = \App\Models\Bankruptcy::where('court_case_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get()
                    ->map(function($record) {
                        $recordArray = $record->toArray();
                        $recordArray['record_type'] = 'bankruptcy';
                        $recordArray['table_name'] = 'bankruptcy';
                        return $recordArray;
                    });
                $results = $results->merge($bankruptcyResults);

                // Search non-individual bankruptcy records by court case number
                $nonIndividualResults = \App\Models\NonIndividualBankruptcy::where('court_case_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get()
                    ->map(function($record) {
                        $recordArray = $record->toArray();
                        $recordArray['record_type'] = 'non-individual-bankruptcy';
                        $recordArray['table_name'] = 'non_individual_bankruptcies';
                        return $recordArray;
                    });
                $results = $results->merge($nonIndividualResults);

                // Search individual annulment records by court case number
                $annulmentResults = AnnulmentIndv::where('court_case_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get()
                    ->map(function($record) {
                        $recordArray = $record->toArray();
                        $recordArray['record_type'] = 'annulment';
                        $recordArray['table_name'] = 'annulment_indv';
                        return $recordArray;
                    });
                $results = $results->merge($annulmentResults);

                // Search non-individual annulment records by court case number
                $annulmentNonIndvResults = \App\Models\AnnulmentNonIndv::where('court_case_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get()
                    ->map(function($record) {
                        $recordArray = $record->toArray();
                        $recordArray['record_type'] = 'non-individual-annulment';
                        $recordArray['table_name'] = 'annulment_non_indv';
                        return $recordArray;
                    });
                $results = $results->merge($annulmentNonIndvResults);

            } elseif ($isInsolvencyNumber) {
                // Create multiple search patterns for insolvency numbers with different separators
                $searchPatterns = [
                    $searchInput, // Original input
                    str_replace(['/', '-', ' '], '', $searchInput), // Remove all separators
                    str_replace(['/', '-'], '', $searchInput), // Remove slash and dash
                    str_replace(['/', ' '], '', $searchInput), // Remove slash and space
                    str_replace(['-', ' '], '', $searchInput), // Remove dash and space
                ];
                
                // Remove duplicates
                $searchPatterns = array_unique($searchPatterns);
                
                \Log::info('Insolvency search patterns', [
                    'original_input' => $searchInput,
                    'search_patterns' => $searchPatterns
                ]);
                
                // Search all tables by insolvency number with multiple patterns
                $bankruptcyResults = collect();
                foreach ($searchPatterns as $pattern) {
                    $bankruptcyResults = $bankruptcyResults->merge(
                        \App\Models\Bankruptcy::where('insolvency_no', 'LIKE', '%' . $pattern . '%')
                            ->where('is_active', true)
                            ->get()
                            ->map(function($record) {
                                $recordArray = $record->toArray();
                                $recordArray['record_type'] = 'bankruptcy';
                                $recordArray['table_name'] = 'bankruptcy';
                                return $recordArray;
                            })
                    );
                }
                $results = $results->merge($bankruptcyResults);

                // Search non-individual bankruptcy records by insolvency number
                $nonIndividualResults = collect();
                foreach ($searchPatterns as $pattern) {
                    $nonIndividualResults = $nonIndividualResults->merge(
                        \App\Models\NonIndividualBankruptcy::where('insolvency_no', 'LIKE', '%' . $pattern . '%')
                            ->where('is_active', true)
                            ->get()
                            ->map(function($record) {
                                $recordArray = $record->toArray();
                                $recordArray['record_type'] = 'non-individual-bankruptcy';
                                $recordArray['table_name'] = 'non_individual_bankruptcies';
                                return $recordArray;
                            })
                    );
                }
                $results = $results->merge($nonIndividualResults);

                // Search individual annulment records by insolvency number
                $annulmentResults = collect();
                foreach ($searchPatterns as $pattern) {
                    $annulmentResults = $annulmentResults->merge(
                        AnnulmentIndv::where('insolvency_no', 'LIKE', '%' . $pattern . '%')
                            ->where('is_active', true)
                            ->get()
                            ->map(function($record) {
                                $recordArray = $record->toArray();
                                $recordArray['record_type'] = 'annulment';
                                $recordArray['table_name'] = 'annulment_indv';
                                return $recordArray;
                            })
                    );
                }
                $results = $results->merge($annulmentResults);

                // Search non-individual annulment records by insolvency number
                $annulmentNonIndvResults = collect();
                foreach ($searchPatterns as $pattern) {
                    $annulmentNonIndvResults = $annulmentNonIndvResults->merge(
                        \App\Models\AnnulmentNonIndv::where('insolvency_no', 'LIKE', '%' . $pattern . '%')
                            ->where('is_active', true)
                            ->get()
                            ->map(function($record) {
                                $recordArray = $record->toArray();
                                $recordArray['record_type'] = 'non-individual-annulment';
                                $recordArray['table_name'] = 'annulment_non_indv';
                                return $recordArray;
                            })
                    );
                }
                $results = $results->merge($annulmentNonIndvResults);

            } elseif ($isICNumber) {
                // Search individual bankruptcy records by IC number
                $bankruptcyResults = \App\Models\Bankruptcy::where('ic_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get()
                    ->map(function($record) {
                        $recordArray = $record->toArray();
                        $recordArray['record_type'] = 'bankruptcy';
                        $recordArray['table_name'] = 'bankruptcy';
                        return $recordArray;
                    });
                $results = $results->merge($bankruptcyResults);

                // Search annulment records by IC number
                $annulmentResults = AnnulmentIndv::where('ic_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get()
                    ->map(function($record) {
                        $recordArray = $record->toArray();
                        $recordArray['record_type'] = 'annulment';
                        $recordArray['table_name'] = 'annulment_indv';
                        return $recordArray;
                    });
                $results = $results->merge($annulmentResults);

            } elseif ($isCompanyRegistration) {
                \Log::info('Searching by company registration number', [
                    'search_input' => $searchInput,
                    'cleaned_input' => preg_replace('/[-\s]/', '', $searchInput)
                ]);
                
                // Search non-individual bankruptcy records by company registration number
                $nonIndividualResults = \App\Models\NonIndividualBankruptcy::where('company_registration_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get()
                    ->map(function($record) {
                        $recordArray = $record->toArray();
                        $recordArray['record_type'] = 'non-individual-bankruptcy';
                        $recordArray['table_name'] = 'non_individual_bankruptcies';
                        return $recordArray;
                    });
                $results = $results->merge($nonIndividualResults);
                
                // Search non-individual annulment records by company registration number
                $annulmentNonIndvResults = \App\Models\AnnulmentNonIndv::where('company_registration_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get()
                    ->map(function($record) {
                        $recordArray = $record->toArray();
                        $recordArray['record_type'] = 'non-individual-annulment';
                        $recordArray['table_name'] = 'annulment_non_indv';
                        return $recordArray;
                    });
                $results = $results->merge($annulmentNonIndvResults);
                    
                \Log::info('Company registration search results', [
                    'bankruptcy_count' => $nonIndividualResults->count(),
                    'annulment_count' => $annulmentNonIndvResults->count(),
                    'total_count' => $results->count(),
                    'search_input' => $searchInput
                ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a valid IC number (12 digits), Company Registration Number (starts with year), Insolvency Number or Court Case Number.'
                ], 400);
            }

            \Log::info('Search results', ['count' => $results->count()]);

            // If no results found, provide helpful message
            if ($results->isEmpty()) {
                $inputType = $isCourtCaseNumber ? 'court case number' : ($isInsolvencyNumber ? 'insolvency number' : ($isCompanyRegistration ? 'company registration number' : ($isICNumber ? 'IC number' : 'unknown')));
                
                return response()->json([
                    'success' => true,
                    'results' => [],
                    'search_input' => $searchInput,
                    'input_type' => $isCourtCaseNumber ? 'court_case_number' : ($isInsolvencyNumber ? 'insolvency_number' : ($isCompanyRegistration ? 'company_registration' : ($isICNumber ? 'ic_number' : 'unknown'))),
                    'searched_types' => $isCourtCaseNumber ? ['individual_bankruptcy', 'non_individual_bankruptcy', 'individual_annulment', 'non_individual_annulment'] : ($isInsolvencyNumber ? ['individual_bankruptcy', 'non_individual_bankruptcy', 'individual_annulment', 'non_individual_annulment'] : ($isICNumber ? ['individual_bankruptcy', 'annulment'] : ['non_individual_bankruptcy', 'non_individual_annulment'])),
                    'message' => "No records found for {$inputType}: {$searchInput}. Please verify the {$inputType} is correct and try again."
                ]);
            }

            return response()->json([
                'success' => true,
                'results' => $results->toArray(),
                'search_input' => $searchInput,
                'input_type' => $isCourtCaseNumber ? 'court_case_number' : ($isInsolvencyNumber ? 'insolvency_number' : ($isCompanyRegistration ? 'company_registration' : ($isICNumber ? 'ic_number' : 'unknown'))),
                'searched_types' => $isCourtCaseNumber ? ['individual_bankruptcy', 'non_individual_bankruptcy', 'individual_annulment', 'non_individual_annulment'] : ($isInsolvencyNumber ? ['individual_bankruptcy', 'non_individual_bankruptcy', 'individual_annulment', 'non_individual_annulment'] : ($isICNumber ? ['individual_bankruptcy', 'annulment'] : ['non_individual_bankruptcy']))
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search only annulment records
     */
    public function searchAnnulment(Request $request)
    {
        try {
            $request->validate([
                'search_input' => 'required|string'
            ]);

            $searchInput = trim($request->input('search_input'));

            \Log::info('Annulment search request received', [
                'search_input' => $searchInput,
                'all_input' => $request->all()
            ]);

            $results = collect();

            // Check if input is a valid IC number or insolvency number
            $isICNumber = $this->isICNumber($searchInput);
            $isInsolvencyNumber = $this->isInsolvencyNumber($searchInput);

            if (!$isICNumber && !$isInsolvencyNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a valid IC number (12 digits) or Insolvency Number for annulment search.'
                ], 400);
            }

            if ($isICNumber) {
                // Search individual annulment records by IC number
            $annulmentResults = AnnulmentIndv::where('ic_no', 'LIKE', '%' . $searchInput . '%')
                ->where('is_active', true)
                ->get()
                ->map(function($record) {
                    $recordArray = $record->toArray();
                    $recordArray['record_type'] = 'annulment';
                    $recordArray['table_name'] = 'annulment_indv';
                    return $recordArray;
                });
                $results = $results->merge($annulmentResults);
            }

            if ($isInsolvencyNumber) {
                // Create multiple search patterns for insolvency numbers with different separators
                $searchPatterns = [
                    $searchInput, // Original input
                    str_replace(['/', '-', ' '], '', $searchInput), // Remove all separators
                    str_replace(['/', '-'], '', $searchInput), // Remove slash and dash
                    str_replace(['/', ' '], '', $searchInput), // Remove slash and space
                    str_replace(['-', ' '], '', $searchInput), // Remove dash and space
                ];
                
                // Remove duplicates
                $searchPatterns = array_unique($searchPatterns);

                // Search individual annulment records by insolvency number
                foreach ($searchPatterns as $pattern) {
                    $annulmentResults = AnnulmentIndv::where('insolvency_no', 'LIKE', '%' . $pattern . '%')
                        ->where('is_active', true)
                        ->get()
                        ->map(function($record) {
                            $recordArray = $record->toArray();
                            $recordArray['record_type'] = 'annulment';
                            $recordArray['table_name'] = 'annulment_indv';
                            return $recordArray;
                        });
                    $results = $results->merge($annulmentResults);
                }

                // Search non-individual annulment records by insolvency number
                foreach ($searchPatterns as $pattern) {
                    $annulmentNonIndvResults = \App\Models\AnnulmentNonIndv::where('insolvency_no', 'LIKE', '%' . $pattern . '%')
                        ->where('is_active', true)
                        ->get()
                        ->map(function($record) {
                            $recordArray = $record->toArray();
                            $recordArray['record_type'] = 'non-individual-annulment';
                            $recordArray['table_name'] = 'annulment_non_indv';
                            return $recordArray;
                        });
                    $results = $results->merge($annulmentNonIndvResults);
                }
            }

            \Log::info('Annulment search results', ['count' => $results->count()]);

            return response()->json([
                'success' => true,
                'results' => $results->toArray(),
                'search_input' => $searchInput,
                'input_type' => $isInsolvencyNumber ? 'insolvency_number' : 'ic_number',
                'searched_types' => $isInsolvencyNumber ? ['individual_annulment', 'non_individual_annulment'] : ['individual_annulment']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if the input is a valid IC number
     */
    private function isICNumber($input)
    {
        // IC number pattern: 12 digits, can contain dashes or spaces
        $cleaned = preg_replace('/[-\s]/', '', $input);
        return preg_match('/^\d{12}$/', $cleaned);
    }

    /**
     * Check if the input is a valid company registration number
     */
    private function isCompanyRegistrationNumber($input)
    {
        // Company registration number pattern: starts with year (4 digits), followed by more digits
        // Malaysian company registration numbers typically start with year (2000-2024) followed by 6-12 digits
        $cleaned = preg_replace('/[-\s]/', '', $input);
        
        // Pattern 1: Standard format (year + 6-12 digits)
        if (preg_match('/^(19|20)\d{2}\d{6,12}$/', $cleaned)) {
            return true;
        }
        
        // Pattern 2: More flexible - any 12+ digit number starting with 19xx or 20xx
        if (preg_match('/^(19|20)\d{2}\d{8,}$/', $cleaned)) {
            return true;
        }
        
        return false;
    }

    /**
     * Check if the input is a valid insolvency number
     */
    private function isInsolvencyNumber($input)
    {
        // Insolvency number pattern: typically starts with letters followed by numbers
        // Common patterns: INS2024001, BK2024001, LC000290/2025, BA-28NCC-364-06/2024, etc.
        $cleaned = trim($input);
        
        // Pattern 1: Letters + numbers only (INS2024001, BK2024001)
        if (preg_match('/^[A-Z]{2,4}\d{6,8}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 2: Letters + numbers with year separator (LC000290/2025)
        if (preg_match('/^[A-Z]{2,4}\d{6,8}\/\d{4}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 3: Letters + numbers with dash separator (LC000290-2025)
        if (preg_match('/^[A-Z]{2,4}\d{6,8}-\d{4}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 4: Letters + numbers with space separator (LC000290 2025)
        if (preg_match('/^[A-Z]{2,4}\d{6,8}\s\d{4}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 5: Letters + numbers with various separators
        if (preg_match('/^[A-Z]{2,4}\d{4,8}[\/\-\s]\d{4}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 6: Complex format with letters and numbers mixed (BA-28NCC-364-06/2024)
        if (preg_match('/^[A-Z]{2,4}-[A-Z0-9]+-[A-Z0-9]+-[A-Z0-9]+\/\d{4}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 7: Complex format with letters and numbers mixed, no final slash (BA-28NCC-364-06)
        if (preg_match('/^[A-Z]{2,4}-[A-Z0-9]+-[A-Z0-9]+-[A-Z0-9]+$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 8: General pattern for complex insolvency numbers with mixed letters/numbers
        if (preg_match('/^[A-Z]{2,4}-[A-Z0-9-]+\/\d{4}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 9: General pattern for complex insolvency numbers without year
        if (preg_match('/^[A-Z]{2,4}-[A-Z0-9-]+$/i', $cleaned)) {
            return true;
        }
        
        return false;
    }

    /**
     * Check if the input is a valid court case number
     */
    private function isCourtCaseNumber($input)
    {
        // Court case number patterns: typically contain letters, numbers, and separators
        // Common patterns: BA-28NCC-364-06/2024, WA-28NCC-152-02/2025, etc.
        $cleaned = trim($input);
        
        // Pattern 1: Complex format with letters and numbers mixed (BA-28NCC-364-06/2024)
        if (preg_match('/^[A-Z]{2,4}-[A-Z0-9]+-[A-Z0-9]+-[A-Z0-9]+\/\d{4}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 2: Complex format with letters and numbers mixed, no final slash (BA-28NCC-364-06)
        if (preg_match('/^[A-Z]{2,4}-[A-Z0-9]+-[A-Z0-9]+-[A-Z0-9]+$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 3: General pattern for complex court case numbers with mixed letters/numbers
        if (preg_match('/^[A-Z]{2,4}-[A-Z0-9-]+\/\d{4}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 4: General pattern for complex court case numbers without year
        if (preg_match('/^[A-Z]{2,4}-[A-Z0-9-]+$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 5: Simple court case pattern (28NCC-1135-11/2024)
        if (preg_match('/^[A-Z0-9]+-[A-Z0-9]+-[A-Z0-9]+\/\d{4}$/i', $cleaned)) {
            return true;
        }
        
        // Pattern 6: Simple court case pattern without year (28NCC-1135-11)
        if (preg_match('/^[A-Z0-9]+-[A-Z0-9]+-[A-Z0-9]+$/i', $cleaned)) {
            return true;
        }
        
        return false;
    }

    /**
     * Bulk status check for all record types
     */
    public function bulkStatusCheck(Request $request)
    {
        try {
            // Get counts for all record types
            $individualBankruptcy = [
                'active' => \App\Models\Bankruptcy::where('is_active', true)->count(),
                'inactive' => \App\Models\Bankruptcy::where('is_active', false)->count(),
                'total' => \App\Models\Bankruptcy::count()
            ];

            $nonIndividualBankruptcy = [
                'active' => \App\Models\NonIndividualBankruptcy::where('is_active', true)->count(),
                'inactive' => \App\Models\NonIndividualBankruptcy::where('is_active', false)->count(),
                'total' => \App\Models\NonIndividualBankruptcy::count()
            ];

            $individualAnnulment = [
                'active' => \App\Models\AnnulmentIndv::where('is_active', true)->count(),
                'inactive' => \App\Models\AnnulmentIndv::where('is_active', false)->count(),
                'total' => \App\Models\AnnulmentIndv::count()
            ];

            $nonIndividualAnnulment = [
                'active' => \App\Models\AnnulmentNonIndv::where('is_active', true)->count(),
                'inactive' => \App\Models\AnnulmentNonIndv::where('is_active', false)->count(),
                'total' => \App\Models\AnnulmentNonIndv::count()
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'individual_bankruptcy' => $individualBankruptcy,
                    'non_individual_bankruptcy' => $nonIndividualBankruptcy,
                    'individual_annulment' => $individualAnnulment,
                    'non_individual_annulment' => $nonIndividualAnnulment
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while checking status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk status check from uploaded Excel file
     */
    public function bulkStatusCheckFromFile(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls|max:10240' // 10MB max
            ]);

            $file = $request->file('excel_file');
            
            // Read Excel file
            $data = \Maatwebsite\Excel\Facades\Excel::toArray(new \stdClass(), $file);
            $rows = $data[0]; // Get first sheet
            
            if (empty($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Excel file is empty or invalid'
                ], 400);
            }

            $records = [];
            $summary = [
                'individual_bankruptcy' => ['active' => 0, 'inactive' => 0, 'total' => 0],
                'non_individual_bankruptcy' => ['active' => 0, 'inactive' => 0, 'total' => 0],
                'individual_annulment' => ['active' => 0, 'inactive' => 0, 'total' => 0],
                'non_individual_annulment' => ['active' => 0, 'inactive' => 0, 'total' => 0]
            ];

            // Process each row (skip header if exists)
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                $name = trim($row[0] ?? '');
                $identifier = trim($row[1] ?? '');
                
                if (empty($name) && empty($identifier)) {
                    continue;
                }

                $record = [
                    'name' => $name,
                    'identifier' => $identifier,
                    'found' => false,
                    'record_type' => null,
                    'is_active' => null,
                    'insolvency_no' => null,
                    'ic_no' => null,
                    'company_name' => null,
                    'company_registration_no' => null
                ];

                // Search in all tables
                $this->searchRecordInTables($record, $identifier, $name);
                
                // Update summary
                if ($record['found']) {
                    $this->updateSummary($summary, $record);
                }

                $records[] = $record;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'records' => $records,
                    'summary' => $summary
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the file: ' . $e->getMessage()
            ], 500);
        }
    }

    private function searchRecordInTables(&$record, $identifier, $name)
    {
        // Search Individual Bankruptcy
        $bankruptcy = \App\Models\Bankruptcy::where('ic_no', $identifier)
            ->orWhere('name', 'LIKE', '%' . $name . '%')
            ->first();
        
        if ($bankruptcy) {
            $record['found'] = true;
            $record['record_type'] = 'Individual Bankruptcy';
            $record['is_active'] = $bankruptcy->is_active;
            $record['insolvency_no'] = $bankruptcy->insolvency_no;
            $record['ic_no'] = $bankruptcy->ic_no;
            $record['name'] = $bankruptcy->name;
            return;
        }

        // Search Non-Individual Bankruptcy
        $nonIndividualBankruptcy = \App\Models\NonIndividualBankruptcy::where('company_registration_no', $identifier)
            ->orWhere('company_name', 'LIKE', '%' . $name . '%')
            ->first();
        
        if ($nonIndividualBankruptcy) {
            $record['found'] = true;
            $record['record_type'] = 'Non-Individual Bankruptcy';
            $record['is_active'] = $nonIndividualBankruptcy->is_active;
            $record['insolvency_no'] = $nonIndividualBankruptcy->insolvency_no;
            $record['company_name'] = $nonIndividualBankruptcy->company_name;
            $record['company_registration_no'] = $nonIndividualBankruptcy->company_registration_no;
            return;
        }

        // Search Individual Annulment
        $individualAnnulment = \App\Models\AnnulmentIndv::where('ic_no', $identifier)
            ->orWhere('name', 'LIKE', '%' . $name . '%')
            ->first();
        
        if ($individualAnnulment) {
            $record['found'] = true;
            $record['record_type'] = 'Individual Annulment';
            $record['is_active'] = $individualAnnulment->is_active;
            $record['insolvency_no'] = $individualAnnulment->insolvency_no;
            $record['ic_no'] = $individualAnnulment->ic_no;
            $record['name'] = $individualAnnulment->name;
            return;
        }

        // Search Non-Individual Annulment
        $nonIndividualAnnulment = \App\Models\AnnulmentNonIndv::where('company_registration_no', $identifier)
            ->orWhere('company_name', 'LIKE', '%' . $name . '%')
            ->first();
        
        if ($nonIndividualAnnulment) {
            $record['found'] = true;
            $record['record_type'] = 'Non-Individual Annulment';
            $record['is_active'] = $nonIndividualAnnulment->is_active;
            $record['insolvency_no'] = $nonIndividualAnnulment->insolvency_no;
            $record['company_name'] = $nonIndividualAnnulment->company_name;
            $record['company_registration_no'] = $nonIndividualAnnulment->company_registration_no;
            return;
        }
    }

    private function updateSummary(&$summary, $record)
    {
        $type = strtolower(str_replace(' ', '_', $record['record_type']));
        
        if (isset($summary[$type])) {
            $summary[$type]['total']++;
            if ($record['is_active']) {
                $summary[$type]['active']++;
            } else {
                $summary[$type]['inactive']++;
            }
        }
    }

    public function getDetails(Request $request, $id)
    {
        try {
            $tableName = $request->get('table');
            $record = null;
            $recordType = null;
            
            // Search specific table based on table name parameter
            switch ($tableName) {
                case 'bankruptcy':
                    $record = \App\Models\Bankruptcy::where('id', $id)->where('is_active', true)->first();
                    $recordType = 'bankruptcy';
                    break;
                    
                case 'annulment_indv':
                    $record = AnnulmentIndv::where('id', $id)->where('is_active', true)->first();
                    $recordType = 'annulment';
                    break;
                    
                case 'non_individual_bankruptcies':
                    $record = \App\Models\NonIndividualBankruptcy::where('id', $id)->where('is_active', true)->first();
                    $recordType = 'non-individual-bankruptcy';
                    break;
                    
                case 'annulment_non_indv':
                    $record = \App\Models\AnnulmentNonIndv::where('id', $id)->where('is_active', true)->first();
                    $recordType = 'non-individual-annulment';
                    break;
                    
                default:
                    // Fallback: search all tables (old behavior for backward compatibility)
                    $records = [];
                    
                    // Try Bankruptcy table
                    $bankruptcyRecord = \App\Models\Bankruptcy::where('id', $id)->where('is_active', true)->first();
                    if ($bankruptcyRecord) {
                        $records[] = ['record' => $bankruptcyRecord, 'type' => 'bankruptcy'];
                    }
                    
                    // Try AnnulmentIndv table
                    $annulmentRecord = AnnulmentIndv::where('id', $id)->where('is_active', true)->first();
                    if ($annulmentRecord) {
                        $records[] = ['record' => $annulmentRecord, 'type' => 'annulment'];
                    }
                    
                    // Try NonIndividualBankruptcy table
                    $nonIndividualRecord = \App\Models\NonIndividualBankruptcy::where('id', $id)->where('is_active', true)->first();
                    if ($nonIndividualRecord) {
                        $records[] = ['record' => $nonIndividualRecord, 'type' => 'non-individual-bankruptcy'];
                    }
                    
                    // Try AnnulmentNonIndv table
                    $annulmentNonIndvRecord = AnnulmentNonIndv::where('id', $id)->where('is_active', true)->first();
                    if ($annulmentNonIndvRecord) {
                        $records[] = ['record' => $annulmentNonIndvRecord, 'type' => 'non-individual-annulment'];
                    }
                    
                    if (empty($records)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Record not found'
                        ], 404);
                    }
                    
                    // Use the first record found
                    $selectedRecord = $records[0];
                    $record = $selectedRecord['record'];
                    $recordType = $selectedRecord['type'];
                    break;
            }
            
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            // Add record type to the response
            $recordArray = $record->toArray();
            $recordArray['record_type'] = $recordType;
            
            return response()->json([
                'success' => true,
                'record' => $recordArray
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
