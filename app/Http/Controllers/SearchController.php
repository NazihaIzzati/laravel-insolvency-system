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
                'ic_number' => 'required|string',
                'search_type' => 'required|in:bankruptcy,annulment'
            ]);

            $icNumber = $request->input('ic_number');
            $searchType = $request->input('search_type');

            \Log::info('Search request received', [
                'ic_number' => $icNumber,
                'search_type' => $searchType,
                'all_input' => $request->all()
            ]);

            // Search in different tables based on search_type
            if ($searchType === 'bankruptcy') {
                $results = \App\Models\Bankruptcy::where('ic_no', 'LIKE', '%' . $icNumber . '%')
                    ->where('is_active', true)
                    ->get();
            } else {
                // Default to annulment search
                $results = AnnulmentIndv::where('ic_no', 'LIKE', '%' . $icNumber . '%')
                    ->where('is_active', true)
                    ->get();
            }

            \Log::info('Search results', ['count' => $results->count()]);

            return response()->json([
                'success' => true,
                'results' => $results->toArray(),
                'search_type' => $searchType,
                'ic_number' => $icNumber
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDetails($id)
    {
        try {
            // Try to find in Bankruptcy table first
            $record = \App\Models\Bankruptcy::where('id', $id)->where('is_active', true)->first();
            
            if (!$record) {
                // If not found in Bankruptcy, try AnnulmentIndv table
                $record = AnnulmentIndv::where('id', $id)->where('is_active', true)->first();
            }
            
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'record' => $record->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
