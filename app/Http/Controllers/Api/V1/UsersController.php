<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        // Use Sanctum guard explicitly 
        $user = auth('sanctum')->user();
        
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }
        
        if (!$user->isAdmin()) {
            return $this->errorResponse('Admin access required', null, 403);
        }

        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'search' => 'sometimes|string|max:255',
        ]);

        $perPage = $validated['per_page'] ?? 20;

        $query = User::query()
            ->select(['id','name','email','role','is_active','created_at'])
            ->orderByDesc('created_at');

        if (!empty($validated['search'])) {
            $s = $validated['search'];
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('role', 'like', "%$s%");
            });
        }

        $users = $query->paginate($perPage);

        return $this->successResponse($users, 'Users retrieved');
    }
}
