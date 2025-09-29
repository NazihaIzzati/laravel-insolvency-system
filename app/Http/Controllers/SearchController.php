<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnulmentIndv;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $request->validate([
                'search_input' => 'required|string'
            ]);

            $searchInput = trim($request->input('search_input'));

            \Log::info('Search request received', [
                'search_input' => $searchInput,
                'all_input' => $request->all()
            ]);

            $results = collect();

            // Auto-detect if input is IC number or company registration number
            $isCompanyRegistration = $this->isCompanyRegistrationNumber($searchInput);
            $isICNumber = $this->isICNumber($searchInput);
            
            // If it matches both patterns, prioritize company registration number
            if ($isCompanyRegistration && $isICNumber) {
                $isICNumber = false; // Prioritize company registration number
            }

            // Search across all relevant tables based on input type
            if ($isICNumber) {
                // Search individual bankruptcy records by IC number
                $bankruptcyResults = \App\Models\Bankruptcy::where('ic_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get();
                $results = $results->merge($bankruptcyResults);

                // Search annulment records by IC number
                $annulmentResults = AnnulmentIndv::where('ic_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get();
                $results = $results->merge($annulmentResults);

            } elseif ($isCompanyRegistration) {
                // Search non-individual bankruptcy records by company registration number
                $nonIndividualResults = \App\Models\NonIndividualBankruptcy::where('company_registration_no', 'LIKE', '%' . $searchInput . '%')
                    ->where('is_active', true)
                    ->get();
                $results = $results->merge($nonIndividualResults);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a valid IC number (12 digits) or Company Registration Number (starts with year).'
                ], 400);
            }

            \Log::info('Search results', ['count' => $results->count()]);

            return response()->json([
                'success' => true,
                'results' => $results->toArray(),
                'search_input' => $searchInput,
                'input_type' => $isCompanyRegistration ? 'company_registration' : ($isICNumber ? 'ic_number' : 'unknown'),
                'searched_types' => $isICNumber ? ['individual_bankruptcy', 'annulment'] : ['non_individual_bankruptcy']
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
        // Malaysian company registration numbers typically start with year (2000-2024) followed by 6-8 digits
        $cleaned = preg_replace('/[-\s]/', '', $input);
        return preg_match('/^(19|20)\d{2}\d{6,8}$/', $cleaned);
    }

    public function getDetails($id)
    {
        try {
            // Search all tables and collect all matches
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
            
            if (empty($records)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            // If multiple records found, prioritize based on field content
            // Non-individual bankruptcy records have company_name field
            $selectedRecord = null;
            foreach ($records as $recordData) {
                if ($recordData['type'] === 'non-individual-bankruptcy' && isset($recordData['record']->company_name)) {
                    $selectedRecord = $recordData;
                    break;
                }
            }
            
            // If no non-individual bankruptcy found, use the first record
            if (!$selectedRecord) {
                $selectedRecord = $records[0];
            }
            
            // Add record type to the response
            $recordArray = $selectedRecord['record']->toArray();
            $recordArray['record_type'] = $selectedRecord['type'];
            
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
