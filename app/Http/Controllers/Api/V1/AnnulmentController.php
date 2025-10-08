<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\AnnulmentResource;
use App\Models\AnnulmentIndv;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnnulmentController extends BaseApiController
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
            'branch' => 'sometimes|string|max:100',
            'release_type' => 'sometimes|string|max:100'
        ]);

        $perPage = $validated['per_page'] ?? 20;

        $query = AnnulmentIndv::query()
            ->where('is_active', true)
            ->orderByDesc('created_at');

        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('ic_no', 'like', "%$search%")
                  ->orWhere('court_case_no', 'like', "%$search%");
            });
        }

        if (!empty($validated['branch'])) {
            $query->where('branch', $validated['branch']);
        }

        if (!empty($validated['release_type'])) {
            $query->where('release_type', $validated['release_type']);
        }

        $annulments = $query->paginate($perPage);

        return $this->successResponse([
            'data' => AnnulmentResource::collection($annulments->items()),
            'meta' => [
                'current_page' => $annulments->currentPage(),
                'per_page' => $annulments->perPage(),
                'total' => $annulments->total(),
                'last_page' => $annulments->lastPage(),
                'from' => $annulments->firstItem(),
                'to' => $annulments->lastItem(),
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ],
            'links' => [
                'first' => $annulments->url(1),
                'last' => $annulments->url($annulments->lastPage()),
                'prev' => $annulments->previousPageUrl(),
                'next' => $annulments->nextPageUrl()
            ]
        ], 'Annulment records retrieved successfully');
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        $annulment = AnnulmentIndv::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$annulment) {
            return $this->errorResponse('Annulment record not found', null, 404);
        }

        return $this->successResponse(
            new AnnulmentResource($annulment),
            'Annulment record retrieved successfully'
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
            'name' => 'required|string|max:255',
            'ic_no' => 'required|string|max:20|unique:annulment_indv,ic_no',
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:100',
            'release_date' => 'nullable|date|before_or_equal:today',
            'release_type' => 'nullable|string|max:100',
            'branch' => 'required|string|max:100'
        ]);

        try {
            $annulment = AnnulmentIndv::create([
                ...$validated,
                'is_active' => true
            ]);

            Log::info('Annulment record created via API', [
                'id' => $annulment->id,
                'user_id' => $user->id,
                'ic_no' => $annulment->ic_no
            ]);

            return $this->successResponse(
                new AnnulmentResource($annulment),
                'Annulment record created successfully',
                201
            );
        } catch (\Exception $e) {
            Log::error('Error creating annulment record via API', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            return $this->errorResponse('Failed to create annulment record', null, 500);
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

        $annulment = AnnulmentIndv::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$annulment) {
            return $this->errorResponse('Annulment record not found', null, 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_no' => "required|string|max:20|unique:annulment_indv,ic_no,$id",
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:100',
            'release_date' => 'nullable|date|before_or_equal:today',
            'release_type' => 'nullable|string|max:100',
            'branch' => 'required|string|max:100'
        ]);

        try {
            $annulment->update($validated);

            Log::info('Annulment record updated via API', [
                'id' => $annulment->id,
                'user_id' => $user->id
            ]);

            return $this->successResponse(
                new AnnulmentResource($annulment->fresh()),
                'Annulment record updated successfully'
            );
        } catch (\Exception $e) {
            Log::error('Error updating annulment record via API', [
                'error' => $e->getMessage(),
                'annulment_id' => $id,
                'user_id' => $user->id
            ]);
            return $this->errorResponse('Failed to update annulment record', null, 500);
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

        $annulment = AnnulmentIndv::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$annulment) {
            return $this->errorResponse('Annulment record not found', null, 404);
        }

        try {
            $annulment->update(['is_active' => false]);

            Log::warning('Annulment record deleted via API', [
                'id' => $annulment->id,
                'user_id' => $user->id,
                'ic_no' => $annulment->ic_no
            ]);

            return $this->successResponse(
                null,
                'Annulment record deleted successfully'
            );
        } catch (\Exception $e) {
            Log::error('Error deleting annulment record via API', [
                'error' => $e->getMessage(),
                'annulment_id' => $id,
                'user_id' => $user->id
            ]);
            return $this->errorResponse('Failed to delete annulment record', null, 500);
        }
    }
}