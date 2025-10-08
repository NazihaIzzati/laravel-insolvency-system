<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HealthController;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Health check endpoint
Route::get('/health', [HealthController::class, 'check'])->name('health');

// Debug route to test token authentication
Route::middleware('auth:sanctum')->get('/debug', function (Request $request) {
    return response()->json([
        'authenticated' => true,
        'user' => $request->user(),
        'token' => $request->bearerToken()
    ]);
})->name('debug');

// Manual token verification test (no middleware)
Route::get('/token-test', function (Request $request) {
    $authHeader = $request->header('Authorization');
    $token = $authHeader ? str_replace('Bearer ', '', $authHeader) : null;
    if (!$token) {
        return response()->json(['error' => 'No token provided']);
    }
    
    // Manually find the token
    $tokenParts = explode('|', $token);
    if (count($tokenParts) !== 2) {
        return response()->json(['error' => 'Invalid token format']);
    }
    
    $tokenId = $tokenParts[0];
    $tokenValue = $tokenParts[1];
    $hashedToken = hash('sha256', $tokenValue);
    
    $dbToken = DB::table('personal_access_tokens')
        ->where('id', $tokenId)
        ->where('token', $hashedToken)
        ->first();
    
    if (!$dbToken) {
        return response()->json(['error' => 'Token not found or invalid']);
    }
    
    $user = App\Models\User::find($dbToken->tokenable_id);
    
    return response()->json([
        'manual_auth' => true,
        'token_id' => $tokenId,
        'user' => $user->only(['id', 'name', 'email', 'role'])
    ]);
})->name('token-test');

// Sanctum auth test with controller
Route::middleware('auth:sanctum')->get('/auth-test', [\App\Http\Controllers\Api\V1\TestController::class, 'auth'])->name('auth-test');

// Simple Sanctum test without any additional middleware
Route::middleware('auth:sanctum')->get('/simple-auth', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Authentication successful',
        'user' => $request->user()->only(['id', 'name', 'email', 'role']),
        'auth_id' => auth('sanctum')->id()
    ]);
})->name('simple-auth');

// Authentication endpoints (using explicit auth checks in controllers)
Route::middleware(['throttle:auth'])->prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/user', [AuthController::class, 'user'])->name('user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
});

// Users listing (with explicit Sanctum guard check in controller)
Route::get('/users', [\App\Http\Controllers\Api\V1\UsersController::class, 'index'])->name('users.index');

// Individual bankruptcy endpoints (explicit auth checks in controllers)
Route::get('/bankruptcies', [\App\Http\Controllers\Api\V1\BankruptcyController::class, 'index'])->name('bankruptcies.index');
Route::get('/bankruptcies/{id}', [\App\Http\Controllers\Api\V1\BankruptcyController::class, 'show'])->name('bankruptcies.show');
Route::post('/bankruptcies', [\App\Http\Controllers\Api\V1\BankruptcyController::class, 'store'])->name('bankruptcies.store');
Route::put('/bankruptcies/{id}', [\App\Http\Controllers\Api\V1\BankruptcyController::class, 'update'])->name('bankruptcies.update');
Route::delete('/bankruptcies/{id}', [\App\Http\Controllers\Api\V1\BankruptcyController::class, 'destroy'])->name('bankruptcies.destroy');

// Annulment endpoints (explicit auth checks in controllers)
Route::get('/annulments', [\App\Http\Controllers\Api\V1\AnnulmentController::class, 'index'])->name('annulments.index');
Route::get('/annulments/{id}', [\App\Http\Controllers\Api\V1\AnnulmentController::class, 'show'])->name('annulments.show');
Route::post('/annulments', [\App\Http\Controllers\Api\V1\AnnulmentController::class, 'store'])->name('annulments.store');
Route::put('/annulments/{id}', [\App\Http\Controllers\Api\V1\AnnulmentController::class, 'update'])->name('annulments.update');
Route::delete('/annulments/{id}', [\App\Http\Controllers\Api\V1\AnnulmentController::class, 'destroy'])->name('annulments.destroy');

// Corporate bankruptcy endpoints (explicit auth checks in controllers) 
Route::get('/corporate-bankruptcies', [\App\Http\Controllers\Api\V1\CorporateBankruptcyController::class, 'index'])->name('corporate-bankruptcies.index');
Route::get('/corporate-bankruptcies/{id}', [\App\Http\Controllers\Api\V1\CorporateBankruptcyController::class, 'show'])->name('corporate-bankruptcies.show');
Route::post('/corporate-bankruptcies', [\App\Http\Controllers\Api\V1\CorporateBankruptcyController::class, 'store'])->name('corporate-bankruptcies.store');
Route::put('/corporate-bankruptcies/{id}', [\App\Http\Controllers\Api\V1\CorporateBankruptcyController::class, 'update'])->name('corporate-bankruptcies.update');
Route::delete('/corporate-bankruptcies/{id}', [\App\Http\Controllers\Api\V1\CorporateBankruptcyController::class, 'destroy'])->name('corporate-bankruptcies.destroy');

// Protected API routes (if needed for middleware-based auth in the future)
Route::middleware(['auth:sanctum'])->group(function () {
    // Other protected routes will go here
});
