<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\BankruptcyResource;
use App\Models\Bankruptcy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BankruptcyController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        // Authentication check
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'search' => 'sometimes|string|max:255',
            'branch' => 'sometimes|string|max:100',
            'status' => 'sometimes|in:active,inactive'
        ]);

        $perPage = $validated['per_page'] ?? 20;

        $query = Bankruptcy::query()
            ->where('is_active', true)
            ->orderByDesc('created_at');

        // Apply filters
        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('ic_no', 'like', "%$search%")
                  ->orWhere('insolvency_no', 'like', "%$search%")
                  ->orWhere('court_case_no', 'like', "%$search%");
            });
        }

        if (!empty($validated['branch'])) {
            $query->where('branch', $validated['branch']);
        }

        $bankruptcies = $query->paginate($perPage);

        return $this->successResponse([
            'data' => BankruptcyResource::collection($bankruptcies->items()),
            'meta' => [
                'current_page' => $bankruptcies->currentPage(),
                'per_page' => $bankruptcies->perPage(),
                'total' => $bankruptcies->total(),
                'last_page' => $bankruptcies->lastPage(),
                'from' => $bankruptcies->firstItem(),
                'to' => $bankruptcies->lastItem(),
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ],
            'links' => [
                'first' => $bankruptcies->url(1),
                'last' => $bankruptcies->url($bankruptcies->lastPage()),
                'prev' => $bankruptcies->previousPageUrl(),
                'next' => $bankruptcies->nextPageUrl()
            ]
        ], 'Bankruptcy records retrieved successfully');
    }

    public function show(Request $request, int $id): JsonResponse
    {
        // Authentication check
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        $bankruptcy = Bankruptcy::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$bankruptcy) {
            return $this->errorResponse('Bankruptcy record not found', null, 404);
        }

        return $this->successResponse(
            new BankruptcyResource($bankruptcy),
            'Bankruptcy record retrieved successfully'
        );
    }

    public function store(Request $request): JsonResponse
    {
        // Authentication and authorization check
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        if (!$user->isAdmin()) {
            return $this->errorResponse('Admin access required', null, 403);
        }

        $validated = $request->validate([
            'insolvency_no' => 'required|string|max:50|unique:bankruptcies,insolvency_no',
            'name' => 'required|string|max:255',
            'ic_no' => 'required|string|max:20|unique:bankruptcies,ic_no',
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:100',
            'ro_date' => 'nullable|date|before_or_equal:today',
            'ao_date' => 'nullable|date|before_or_equal:today',
            'branch' => 'required|string|max:100'
        ]);

        try {
            $bankruptcy = Bankruptcy::create([
                ...$validated,
                'is_active' => true
            ]);

            Log::info('Bankruptcy record created via API', [
                'id' => $bankruptcy->id,
                'user_id' => $user->id,
                'insolvency_no' => $bankruptcy->insolvency_no
            ]);

            return $this->successResponse(
                new BankruptcyResource($bankruptcy),
                'Bankruptcy record created successfully',
                201
            );
        } catch (\Exception $e) {
            Log::error('Error creating bankruptcy record via API', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            return $this->errorResponse('Failed to create bankruptcy record', null, 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        // Authentication and authorization check
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        if (!$user->isAdmin()) {
            return $this->errorResponse('Admin access required', null, 403);
        }

        $bankruptcy = Bankruptcy::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$bankruptcy) {
            return $this->errorResponse('Bankruptcy record not found', null, 404);
        }

        $validated = $request->validate([
            'insolvency_no' => "required|string|max:50|unique:bankruptcies,insolvency_no,$id",
            'name' => 'required|string|max:255',
            'ic_no' => "required|string|max:20|unique:bankruptcies,ic_no,$id",
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:100',
            'ro_date' => 'nullable|date|before_or_equal:today',
            'ao_date' => 'nullable|date|before_or_equal:today',
            'branch' => 'required|string|max:100'
        ]);

        try {
            $bankruptcy->update($validated);

            Log::info('Bankruptcy record updated via API', [
                'id' => $bankruptcy->id,
                'user_id' => $user->id
            ]);

            return $this->successResponse(
                new BankruptcyResource($bankruptcy->fresh()),
                'Bankruptcy record updated successfully'
            );
        } catch (\Exception $e) {
            Log::error('Error updating bankruptcy record via API', [
                'error' => $e->getMessage(),
                'bankruptcy_id' => $id,
                'user_id' => $user->id
            ]);
            return $this->errorResponse('Failed to update bankruptcy record', null, 500);
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        // Authentication and authorization check
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        if (!$user->isAdmin()) {
            return $this->errorResponse('Admin access required', null, 403);
        }

        $bankruptcy = Bankruptcy::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$bankruptcy) {
            return $this->errorResponse('Bankruptcy record not found', null, 404);
        }

        try {
            // Soft delete by setting is_active to false
            $bankruptcy->update(['is_active' => false]);

            Log::warning('Bankruptcy record deleted via API', [
                'id' => $bankruptcy->id,
                'user_id' => $user->id,
                'insolvency_no' => $bankruptcy->insolvency_no
            ]);

            return $this->successResponse(
                null,
                'Bankruptcy record deleted successfully'
            );
        } catch (\Exception $e) {
            Log::error('Error deleting bankruptcy record via API', [
                'error' => $e->getMessage(),
                'bankruptcy_id' => $id,
                'user_id' => $user->id
            ]);
            return $this->errorResponse('Failed to delete bankruptcy record', null, 500);
        }
    }
}