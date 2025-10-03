<?php

use Illuminate\Support\Facades\Route;
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

// Authentication endpoints
Route::middleware(['throttle:auth'])->prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user'])->name('user');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    });
});

// Protected API routes
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // Load protected route files (will be created in next phases)
    // require __DIR__ . '/protected/users.php';
    // require __DIR__ . '/protected/bankruptcies.php';
    // require __DIR__ . '/protected/annulments.php';
    // require __DIR__ . '/protected/corporate_bankruptcies.php';
    // require __DIR__ . '/protected/search.php';
    // require __DIR__ . '/protected/statistics.php';
    // require __DIR__ . '/protected/admin.php';
});