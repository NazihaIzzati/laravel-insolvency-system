<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestController extends BaseApiController
{
    public function auth(Request $request): JsonResponse
    {
        // This method will be called with auth:sanctum middleware
        return $this->successResponse([
            'authenticated' => true,
            'user' => $request->user(),
            'token' => $request->bearerToken(),
            'auth_guard' => auth()->getDefaultDriver(),
            'user_id' => auth()->id(),
        ], 'Sanctum authentication successful');
    }
}