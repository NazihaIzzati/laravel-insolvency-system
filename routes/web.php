<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AnnulmentIndvController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BankruptcyController;
use App\Http\Controllers\NonIndividualBankruptcyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/test-search', function () {
    return view('test-search');
})->name('test-search');

// Test search route without auth
Route::post('/test-search-api', [SearchController::class, 'search'])->name('test-search-api');


// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Annulment Individual management routes
    Route::resource('annulment-indv', AnnulmentIndvController::class);
    
    // Bankruptcy management routes
    Route::get('/bankruptcy/bulk-upload', [BankruptcyController::class, 'bulkUpload'])->name('bankruptcy.bulk-upload');
    Route::post('/bankruptcy/bulk-upload', [BankruptcyController::class, 'processBulkUpload'])->name('bankruptcy.bulk-upload.process');
    Route::get('/bankruptcy/debug-import', function() { return view('bankruptcy.debug-import'); })->name('bankruptcy.debug-import');
    Route::post('/bankruptcy/debug-import', [BankruptcyController::class, 'debugImport'])->name('bankruptcy.debug-import.process');
    Route::get('/bankruptcy/test-import', [BankruptcyController::class, 'testImport'])->name('bankruptcy.test-import');
    Route::get('/bankruptcy/template', [BankruptcyController::class, 'downloadTemplate'])->name('bankruptcy.template');
    Route::resource('bankruptcy', BankruptcyController::class);
    
    // Non-Individual Bankruptcy management routes
    Route::get('/non-individual-bankruptcy/bulk-upload', [NonIndividualBankruptcyController::class, 'bulkUpload'])->name('non-individual-bankruptcy.bulk-upload');
    Route::post('/non-individual-bankruptcy/bulk-upload', [NonIndividualBankruptcyController::class, 'processBulkUpload'])->name('non-individual-bankruptcy.bulk-upload.process');
    Route::get('/non-individual-bankruptcy/template', [NonIndividualBankruptcyController::class, 'downloadTemplate'])->name('non-individual-bankruptcy.template');
    Route::resource('non-individual-bankruptcy', NonIndividualBankruptcyController::class);
    
    // Search routes
    Route::post('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/search/details/{id}', [SearchController::class, 'getDetails'])->name('search.details');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
