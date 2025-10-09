<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AnnulmentIndvController;
use App\Http\Controllers\AnnulmentNonIndvController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BankruptcyController;
use App\Http\Controllers\NonIndividualBankruptcyController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AuditLogController;
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
    
    // Change password routes
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [ChangePasswordController::class, 'updatePassword'])->name('password.update');
    
    // Annulment Individual management routes
    Route::get('/annulment-indv/bulk-upload', [AnnulmentIndvController::class, 'bulkUpload'])->name('annulment-indv.bulk-upload');
    Route::post('/annulment-indv/bulk-upload', [AnnulmentIndvController::class, 'processBulkUpload'])->name('annulment-indv.bulk-upload.process');
    Route::get('/annulment-indv/template', [AnnulmentIndvController::class, 'downloadTemplate'])->name('annulment-indv.template');
    Route::get('/annulment-indv/download', [AnnulmentIndvController::class, 'downloadRecords'])->name('annulment-indv.download');
    Route::post('/annulment-indv/search', [AnnulmentIndvController::class, 'search'])->name('annulment-indv.search');
    Route::resource('annulment-indv', AnnulmentIndvController::class);
    
    // Annulment Non-Individual management routes
    Route::get('/annulment-non-indv/bulk-upload', [AnnulmentNonIndvController::class, 'bulkUpload'])->name('annulment-non-indv.bulk-upload');
    Route::post('/annulment-non-indv/bulk-upload', [AnnulmentNonIndvController::class, 'processBulkUpload'])->name('annulment-non-indv.bulk-upload.process');
    Route::get('/annulment-non-indv/template', [AnnulmentNonIndvController::class, 'downloadTemplate'])->name('annulment-non-indv.template');
    Route::get('/annulment-non-indv/download', [AnnulmentNonIndvController::class, 'downloadRecords'])->name('annulment-non-indv.download');
    Route::post('/annulment-non-indv/search', [AnnulmentNonIndvController::class, 'search'])->name('annulment-non-indv.search');
    Route::resource('annulment-non-indv', AnnulmentNonIndvController::class);
    
    // Bankruptcy management routes
    Route::get('/bankruptcy/bulk-upload', [BankruptcyController::class, 'bulkUpload'])->name('bankruptcy.bulk-upload');
    Route::post('/bankruptcy/bulk-upload', [BankruptcyController::class, 'processBulkUpload'])->name('bankruptcy.bulk-upload.process');
    Route::get('/bankruptcy/debug-import', function() { return view('bankruptcy.debug-import'); })->name('bankruptcy.debug-import');
    Route::post('/bankruptcy/debug-import', [BankruptcyController::class, 'debugImport'])->name('bankruptcy.debug-import.process');
    Route::get('/bankruptcy/test-import', [BankruptcyController::class, 'testImport'])->name('bankruptcy.test-import');
    Route::get('/bankruptcy/template', [BankruptcyController::class, 'downloadTemplate'])->name('bankruptcy.template');
    Route::get('/bankruptcy/download', [BankruptcyController::class, 'downloadRecords'])->name('bankruptcy.download');
    Route::post('/bankruptcy/search', [BankruptcyController::class, 'search'])->name('bankruptcy.search');
    Route::resource('bankruptcy', BankruptcyController::class);
    
    // Non-Individual Bankruptcy management routes
    Route::get('/non-individual-bankruptcy/bulk-upload', [NonIndividualBankruptcyController::class, 'bulkUpload'])->name('non-individual-bankruptcy.bulk-upload');
    Route::post('/non-individual-bankruptcy/bulk-upload', [NonIndividualBankruptcyController::class, 'processBulkUpload'])->name('non-individual-bankruptcy.bulk-upload.process');
    Route::get('/non-individual-bankruptcy/template', [NonIndividualBankruptcyController::class, 'downloadTemplate'])->name('non-individual-bankruptcy.template');
    Route::get('/non-individual-bankruptcy/download', [NonIndividualBankruptcyController::class, 'downloadRecords'])->name('non-individual-bankruptcy.download');
    Route::post('/non-individual-bankruptcy/search', [NonIndividualBankruptcyController::class, 'search'])->name('non-individual-bankruptcy.search');
    Route::resource('non-individual-bankruptcy', NonIndividualBankruptcyController::class);
    
    // Search routes
    Route::post('/search', [SearchController::class, 'search'])->name('search');
    Route::post('/search/annulment', [SearchController::class, 'searchAnnulment'])->name('search.annulment');
    Route::get('/search/details/{id}', [SearchController::class, 'getDetails'])->name('search.details');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// User Management routes (Admin only)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management.index');
    Route::get('/user-management/create', [UserManagementController::class, 'create'])->name('user-management.create');
    Route::post('/user-management', [UserManagementController::class, 'store'])->name('user-management.store');
    Route::get('/user-management/{user}', [UserManagementController::class, 'show'])->name('user-management.show');
    Route::get('/user-management/{user}/edit', [UserManagementController::class, 'edit'])->name('user-management.edit');
    Route::put('/user-management/{user}', [UserManagementController::class, 'update'])->name('user-management.update');
    Route::delete('/user-management/{user}', [UserManagementController::class, 'destroy'])->name('user-management.destroy');
    Route::post('/user-management/{id}/restore', [UserManagementController::class, 'restore'])->name('user-management.restore');
    Route::delete('/user-management/{id}/force-delete', [UserManagementController::class, 'forceDelete'])->name('user-management.force-delete');
    Route::post('/user-management/{user}/change-password', [UserManagementController::class, 'changePassword'])->name('user-management.change-password');
    
    // Bulk operations
    Route::get('/user-management/bulk-upload', [UserManagementController::class, 'bulkUpload'])->name('user-management.bulk-upload');
    Route::post('/user-management/bulk-upload', [UserManagementController::class, 'processBulkUpload'])->name('user-management.bulk-upload.process');
    Route::get('/user-management/template', [UserManagementController::class, 'downloadTemplate'])->name('user-management.template');
    Route::get('/user-management/download', [UserManagementController::class, 'downloadUsers'])->name('user-management.download');
    
    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
    Route::get('/audit-logs/export', [AuditLogController::class, 'export'])->name('audit-logs.export');
});
