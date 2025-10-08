<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\CorporateBankruptcyResource;
use App\Models\NonIndividualBankruptcy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CorporateBankruptcyController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'search' => 'sometimes|string|max:255',
            'branch' => 'sometimes|string|max:100'
        ]);

        $perPage = $validated['per_page'] ?? 20;

        $query = NonIndividualBankruptcy::query()
            ->where('is_active', true)
            ->orderByDesc('created_at');

        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%$search%")
                  ->orWhere('company_registration_no', 'like', "%$search%")
                  ->orWhere('insolvency_no', 'like', "%$search%")
                  ->orWhere('court_case_no', 'like', "%$search%");
            });
        }

        if (!empty($validated['branch'])) {
            $query->where('branch', $validated['branch']);
        }

        $corporateBankruptcies = $query->paginate($perPage);

        return $this->successResponse([
            'data' => CorporateBankruptcyResource::collection($corporateBankruptcies->items()),
            'meta' => [
                'current_page' => $corporateBankruptcies->currentPage(),
                'per_page' => $corporateBankruptcies->perPage(),
                'total' => $corporateBankruptcies->total(),
                'last_page' => $corporateBankruptcies->lastPage(),
                'from' => $corporateBankruptcies->firstItem(),
                'to' => $corporateBankruptcies->lastItem(),
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ],
            'links' => [
                'first' => $corporateBankruptcies->url(1),
                'last' => $corporateBankruptcies->url($corporateBankruptcies->lastPage()),
                'prev' => $corporateBankruptcies->previousPageUrl(),
                'next' => $corporateBankruptcies->nextPageUrl()
            ]
        ], 'Corporate bankruptcy records retrieved successfully');
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        $corporateBankruptcy = NonIndividualBankruptcy::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$corporateBankruptcy) {
            return $this->errorResponse('Corporate bankruptcy record not found', null, 404);
        }

        return $this->successResponse(
            new CorporateBankruptcyResource($corporateBankruptcy),
            'Corporate bankruptcy record retrieved successfully'
        );
    }

    public function store(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        if (!$user->isAdmin()) {
            return $this->errorResponse('Admin access required', null, 403);
        }

        $validated = $request->validate([
            'insolvency_no' => 'required|string|max:50|unique:non_individual_bankruptcies,insolvency_no',
            'company_name' => 'required|string|max:255',
            'company_registration_no' => 'required|string|max:50|unique:non_individual_bankruptcies,company_registration_no',
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:100',
            'date_of_winding_up_resolution' => 'nullable|date|before_or_equal:today',
            'branch' => 'required|string|max:100'
        ]);

        try {
            $corporateBankruptcy = NonIndividualBankruptcy::create([
                ...$validated,
                'is_active' => true
            ]);

            Log::info('Corporate bankruptcy record created via API', [
                'id' => $corporateBankruptcy->id,
                'user_id' => $user->id,
                'insolvency_no' => $corporateBankruptcy->insolvency_no
            ]);

            return $this->successResponse(
                new CorporateBankruptcyResource($corporateBankruptcy),
                'Corporate bankruptcy record created successfully',
                201
            );
        } catch (\Exception $e) {
            Log::error('Error creating corporate bankruptcy record via API', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            return $this->errorResponse('Failed to create corporate bankruptcy record', null, 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        if (!$user->isAdmin()) {
            return $this->errorResponse('Admin access required', null, 403);
        }

        $corporateBankruptcy = NonIndividualBankruptcy::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$corporateBankruptcy) {
            return $this->errorResponse('Corporate bankruptcy record not found', null, 404);
        }

        $validated = $request->validate([
            'insolvency_no' => "required|string|max:50|unique:non_individual_bankruptcies,insolvency_no,$id",
            'company_name' => 'required|string|max:255',
            'company_registration_no' => "required|string|max:50|unique:non_individual_bankruptcies,company_registration_no,$id",
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:100',
            'date_of_winding_up_resolution' => 'nullable|date|before_or_equal:today',
            'branch' => 'required|string|max:100'
        ]);

        try {
            $corporateBankruptcy->update($validated);

            Log::info('Corporate bankruptcy record updated via API', [
                'id' => $corporateBankruptcy->id,
                'user_id' => $user->id
            ]);

            return $this->successResponse(
                new CorporateBankruptcyResource($corporateBankruptcy->fresh()),
                'Corporate bankruptcy record updated successfully'
            );
        } catch (\Exception $e) {
            Log::error('Error updating corporate bankruptcy record via API', [
                'error' => $e->getMessage(),
                'corporate_bankruptcy_id' => $id,
                'user_id' => $user->id
            ]);
            return $this->errorResponse('Failed to update corporate bankruptcy record', null, 500);
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        if (!$user->isAdmin()) {
            return $this->errorResponse('Admin access required', null, 403);
        }

        $corporateBankruptcy = NonIndividualBankruptcy::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$corporateBankruptcy) {
            return $this->errorResponse('Corporate bankruptcy record not found', null, 404);
        }

        try {
            $corporateBankruptcy->update(['is_active' => false]);

            Log::warning('Corporate bankruptcy record deleted via API', [
                'id' => $corporateBankruptcy->id,
                'user_id' => $user->id,
                'insolvency_no' => $corporateBankruptcy->insolvency_no
            ]);

            return $this->successResponse(
                null,
                'Corporate bankruptcy record deleted successfully'
            );
        } catch (\Exception $e) {
            Log::error('Error deleting corporate bankruptcy record via API', [
                'error' => $e->getMessage(),
                'corporate_bankruptcy_id' => $id,
                'user_id' => $user->id
            ]);
            return $this->errorResponse('Failed to delete corporate bankruptcy record', null, 500);
        }
    }
}