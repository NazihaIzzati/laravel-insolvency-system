<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends BaseApiController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->attemptLogin($request->validated(), $request->boolean('remember'));

            if (!$user) {
                Log::warning('API login failed', ['email' => $request->email, 'ip' => $request->ip()]);
                return $this->errorResponse('Invalid credentials', null, 401);
            }

            $token = $user->createToken('API Token', ['*'])->plainTextToken;

            Log::info('API login success', ['user_id' => $user->id, 'ip' => $request->ip()]);

            return $this->successResponse([
                'user' => $user->only(['id', 'name', 'email', 'role', 'is_active']),
                'token' => $token,
                'token_type' => 'Bearer'
            ], 'Login successful');
        } catch (\Exception $e) {
            Log::error('API login error', ['error' => $e->getMessage()]);
            return $this->errorResponse('An error occurred during login', null, 500);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->register($request->validated());
            $token = $user->createToken('API Token', ['*'])->plainTextToken;

            Log::info('API register success', ['user_id' => $user->id, 'ip' => $request->ip()]);

            return $this->successResponse([
                'user' => $user->only(['id', 'name', 'email', 'role', 'is_active']),
                'token' => $token,
                'token_type' => 'Bearer'
            ], 'Registration successful', 201);
        } catch (\Exception $e) {
            Log::error('API register error', ['error' => $e->getMessage()]);
            return $this->errorResponse('Registration failed', null, 500);
        }
    }

    public function user(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        return $this->successResponse(
            $user->only(['id', 'name', 'email', 'role', 'is_active', 'created_at'])
        );
    }

    public function logout(Request $request): JsonResponse
    {
        // Extract token from Authorization header
        $authHeader = $request->header('Authorization');
        $token = $authHeader ? str_replace('Bearer ', '', $authHeader) : null;
        
        if (!$token) {
            return $this->errorResponse('Token required', null, 401);
        }
        
        // Find and authenticate user using token
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Invalid token', null, 401);
        }
        
        // Manually find and delete the token
        $tokenParts = explode('|', $token);
        if (count($tokenParts) === 2) {
            $tokenId = $tokenParts[0];
            $tokenValue = $tokenParts[1];
            $hashedToken = hash('sha256', $tokenValue);
            
            // Delete the token from database
            \Illuminate\Support\Facades\DB::table('personal_access_tokens')
                ->where('id', $tokenId)
                ->where('token', $hashedToken)
                ->delete();
        }
        
        Log::info('API logout', ['user_id' => $user->id, 'ip' => $request->ip()]);

        return $this->successResponse(null, 'Logged out successfully');
    }

    public function refresh(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return $this->errorResponse('Authentication required', null, 401);
        }

        // Delete current token
        $currentToken = $user->currentAccessToken();
        if ($currentToken) {
            $currentToken->delete();
        }
        
        // Create new token
        $token = $user->createToken('API Token', ['*'])->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'token_type' => 'Bearer'
        ], 'Token refreshed successfully');
    }
}
