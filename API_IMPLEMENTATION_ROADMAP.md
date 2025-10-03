# API Implementation Roadmap

## Implementation Plan Summary

This document provides a step-by-step implementation plan for creating a comprehensive API for the Laravel Insolvency System. The implementation is designed with security best practices and prepares the system for penetration testing.

---

## Phase 1: Core API Infrastructure

### Step 1: Create API Versioning Structure

#### 1.1 Update RouteServiceProvider
```php
// app/Providers/RouteServiceProvider.php
public function boot(): void
{
    $this->routes(function () {
        Route::middleware('api')
            ->prefix('api/v1')
            ->name('api.v1.')
            ->group(base_path('routes/api/v1.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    });
}
```

#### 1.2 Create API Route File Structure
```bash
mkdir -p routes/api
touch routes/api/v1.php
```

#### 1.3 Base API Routes (routes/api/v1.php)
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\HealthController;

// Health check endpoint
Route::get('/health', [HealthController::class, 'check'])->name('health');

// Authentication endpoints
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user'])->name('user');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    });
});

// Protected API routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Load protected route files
    require __DIR__ . '/protected/users.php';
    require __DIR__ . '/protected/bankruptcies.php';
    require __DIR__ . '/protected/annulments.php';
    require __DIR__ . '/protected/corporate_bankruptcies.php';
    require __DIR__ . '/protected/search.php';
    require __DIR__ . '/protected/statistics.php';
    require __DIR__ . '/protected/admin.php';
});
```

### Step 2: Create Base API Controller

#### 2.1 Base API Controller
```php
<?php
// app/Http/Controllers/Api/BaseApiController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseApiController extends Controller
{
    protected function successResponse($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ];

        if ($data !== null) {
            if ($data instanceof LengthAwarePaginator) {
                $response['data'] = $data->items();
                $response['meta'] = array_merge($response['meta'], [
                    'current_page' => $data->currentPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                    'last_page' => $data->lastPage(),
                    'from' => $data->firstItem(),
                    'to' => $data->lastItem()
                ]);
                $response['links'] = [
                    'first' => $data->url(1),
                    'last' => $data->url($data->lastPage()),
                    'prev' => $data->previousPageUrl(),
                    'next' => $data->nextPageUrl()
                ];
            } else {
                $response['data'] = $data;
            }
        }

        return response()->json($response, $code);
    }

    protected function errorResponse(string $message = 'Error', $errors = null, int $code = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'error' => [
                'code' => $this->getErrorCode($code),
                'message' => $message
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ];

        if ($errors !== null) {
            $response['error']['details'] = $errors;
        }

        return response()->json($response, $code);
    }

    private function getErrorCode(int $httpCode): string
    {
        return match($httpCode) {
            400 => 'BAD_REQUEST',
            401 => 'UNAUTHORIZED',
            403 => 'FORBIDDEN',
            404 => 'NOT_FOUND',
            422 => 'VALIDATION_ERROR',
            429 => 'RATE_LIMITED',
            500 => 'INTERNAL_SERVER_ERROR',
            default => 'UNKNOWN_ERROR'
        };
    }

    protected function validatePagination(Request $request): array
    {
        return $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100'
        ]);
    }
}
```

### Step 3: Authentication System

#### 3.1 API Authentication Controller
```php
<?php
// app/Http/Controllers/Api/V1/AuthController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends BaseApiController
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->attemptLogin($request->validated(), $request->boolean('remember'));
            
            if (!$user) {
                Log::warning('Failed login attempt', ['email' => $request->email, 'ip' => $request->ip()]);
                return $this->errorResponse('Invalid credentials', null, 401);
            }

            $token = $user->createToken('API Token', ['*'])->plainTextToken;
            
            Log::info('Successful API login', ['user_id' => $user->id, 'ip' => $request->ip()]);

            return $this->successResponse([
                'user' => $user->only(['id', 'name', 'email', 'role', 'is_active']),
                'token' => $token,
                'token_type' => 'Bearer'
            ], 'Login successful');
            
        } catch (\Exception $e) {
            Log::error('Login error', ['error' => $e->getMessage(), 'email' => $request->email]);
            return $this->errorResponse('An error occurred during login', null, 500);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->authService->register($request->validated());
            $token = $user->createToken('API Token', ['*'])->plainTextToken;
            
            Log::info('New user registered via API', ['user_id' => $user->id, 'ip' => $request->ip()]);

            return $this->successResponse([
                'user' => $user->only(['id', 'name', 'email', 'role', 'is_active']),
                'token' => $token,
                'token_type' => 'Bearer'
            ], 'Registration successful', 201);
            
        } catch (\Exception $e) {
            Log::error('Registration error', ['error' => $e->getMessage(), 'email' => $request->email ?? 'unknown']);
            return $this->errorResponse('Registration failed', null, 500);
        }
    }

    public function user(Request $request): JsonResponse
    {
        return $this->successResponse(
            $request->user()->only(['id', 'name', 'email', 'role', 'is_active', 'created_at'])
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Revoke current token
        $request->user()->currentAccessToken()->delete();
        
        Log::info('User logged out via API', ['user_id' => $user->id, 'ip' => $request->ip()]);
        
        return $this->successResponse(null, 'Logged out successfully');
    }

    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Revoke current token and create new one
        $request->user()->currentAccessToken()->delete();
        $token = $user->createToken('API Token', ['*'])->plainTextToken;
        
        return $this->successResponse([
            'token' => $token,
            'token_type' => 'Bearer'
        ], 'Token refreshed successfully');
    }
}
```

#### 3.2 Request Validation Classes
```php
<?php
// app/Http/Requests/Api/LoginRequest.php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'remember' => 'boolean'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'The given data was invalid.',
                    'details' => $validator->errors()
                ],
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => 'v1'
                ]
            ], 422)
        );
    }
}
```

### Step 4: Security Middleware

#### 4.1 Rate Limiting Configuration
```php
// app/Providers/RouteServiceProvider.php - Add to boot method

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('search', function (Request $request) {
    return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('auth', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

RateLimiter::for('admin', function (Request $request) {
    return Limit::perMinute(100)->by($request->user()?->id ?: $request->ip());
});
```

#### 4.2 API Security Middleware
```php
<?php
// app/Http/Middleware/ApiSecurityMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiSecurityMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Log all API requests for security monitoring
        Log::info('API Request', [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'user_id' => auth()->id(),
            'timestamp' => now()->toISOString()
        ]);

        // Add security headers
        $response = $next($request);
        
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        return $response;
    }
}
```

#### 4.3 Register Middleware
```php
// app/Http/Kernel.php - Add to $middlewareGroups

'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    \App\Http\Middleware\ApiSecurityMiddleware::class,
],
```

### Step 5: Health Check Endpoint

#### 5.1 Health Controller
```php
<?php
// app/Http/Controllers/Api/V1/HealthController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HealthController extends BaseApiController
{
    public function check(): JsonResponse
    {
        $checks = [
            'status' => 'healthy',
            'timestamp' => now()->toISOString(),
            'version' => config('app.version', '1.0.0'),
            'environment' => app()->environment(),
            'checks' => []
        ];

        // Database check
        try {
            DB::connection()->getPdo();
            $checks['checks']['database'] = ['status' => 'healthy', 'response_time' => $this->measureTime(fn() => DB::select('SELECT 1'))];
        } catch (\Exception $e) {
            $checks['checks']['database'] = ['status' => 'unhealthy', 'error' => 'Database connection failed'];
            $checks['status'] = 'unhealthy';
        }

        // Cache check
        try {
            Cache::put('health_check', 'ok', 10);
            $value = Cache::get('health_check');
            $checks['checks']['cache'] = ['status' => $value === 'ok' ? 'healthy' : 'unhealthy'];
        } catch (\Exception $e) {
            $checks['checks']['cache'] = ['status' => 'unhealthy', 'error' => 'Cache system failed'];
        }

        // Disk space check
        $diskFree = disk_free_space(storage_path());
        $diskTotal = disk_total_space(storage_path());
        $diskUsage = (($diskTotal - $diskFree) / $diskTotal) * 100;
        
        $checks['checks']['disk'] = [
            'status' => $diskUsage < 90 ? 'healthy' : 'warning',
            'usage_percentage' => round($diskUsage, 2),
            'free_space_mb' => round($diskFree / 1024 / 1024)
        ];

        return response()->json($checks, $checks['status'] === 'healthy' ? 200 : 503);
    }

    private function measureTime(callable $callback): float
    {
        $start = microtime(true);
        $callback();
        return round((microtime(true) - $start) * 1000, 2); // milliseconds
    }
}
```

---

## Phase 2: CRUD Operations Implementation

### Step 6: Bankruptcy API Implementation

#### 6.1 Protected Routes (routes/api/protected/bankruptcies.php)
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BankruptcyController;

Route::middleware(['throttle:api'])->prefix('bankruptcies')->name('bankruptcies.')->group(function () {
    Route::get('/', [BankruptcyController::class, 'index'])->name('index');
    Route::post('/', [BankruptcyController::class, 'store'])->middleware('can:create,App\Models\Bankruptcy')->name('store');
    Route::get('/{bankruptcy}', [BankruptcyController::class, 'show'])->name('show');
    Route::put('/{bankruptcy}', [BankruptcyController::class, 'update'])->middleware('can:update,bankruptcy')->name('update');
    Route::delete('/{bankruptcy}', [BankruptcyController::class, 'destroy'])->middleware('can:delete,bankruptcy')->name('destroy');
    
    // Bulk operations (admin only)
    Route::middleware(['admin'])->group(function () {
        Route::post('/bulk', [BankruptcyController::class, 'bulkStore'])->name('bulk.store');
        Route::get('/export', [BankruptcyController::class, 'export'])->name('export');
    });
    
    // Search
    Route::post('/search', [BankruptcyController::class, 'search'])->middleware('throttle:search')->name('search');
});
```

#### 6.2 Bankruptcy API Controller
```php
<?php
// app/Http/Controllers/Api/V1/BankruptcyController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\StoreBankruptcyRequest;
use App\Http\Requests\Api\UpdateBankruptcyRequest;
use App\Http\Requests\Api\SearchBankruptcyRequest;
use App\Http\Resources\Api\BankruptcyResource;
use App\Models\Bankruptcy;
use App\Services\BankruptcyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BankruptcyController extends BaseApiController
{
    public function __construct(
        private BankruptcyService $bankruptcyService
    ) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $this->validatePagination($request);
            
            $bankruptcies = Bankruptcy::with([])
                ->where('is_active', true)
                ->when($request->filled('branch'), fn($q) => $q->where('branch', $request->branch))
                ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
                ->latest('updated_at')
                ->paginate($request->input('per_page', 20));

            return $this->successResponse(
                BankruptcyResource::collection($bankruptcies)->response()->getData()
            );
            
        } catch (\Exception $e) {
            Log::error('Error fetching bankruptcies', ['error' => $e->getMessage(), 'user' => auth()->id()]);
            return $this->errorResponse('Failed to fetch bankruptcy records', null, 500);
        }
    }

    public function store(StoreBankruptcyRequest $request): JsonResponse
    {
        try {
            $bankruptcy = $this->bankruptcyService->create($request->validated());
            
            Log::info('Bankruptcy record created', [
                'id' => $bankruptcy->id,
                'user_id' => auth()->id(),
                'insolvency_no' => $bankruptcy->insolvency_no
            ]);

            return $this->successResponse(
                new BankruptcyResource($bankruptcy),
                'Bankruptcy record created successfully',
                201
            );
            
        } catch (\Exception $e) {
            Log::error('Error creating bankruptcy', ['error' => $e->getMessage(), 'user' => auth()->id()]);
            return $this->errorResponse('Failed to create bankruptcy record', null, 500);
        }
    }

    public function show(Bankruptcy $bankruptcy): JsonResponse
    {
        if (!$bankruptcy->is_active) {
            return $this->errorResponse('Bankruptcy record not found', null, 404);
        }

        return $this->successResponse(new BankruptcyResource($bankruptcy));
    }

    public function update(UpdateBankruptcyRequest $request, Bankruptcy $bankruptcy): JsonResponse
    {
        try {
            $oldData = $bankruptcy->toArray();
            $bankruptcy = $this->bankruptcyService->update($bankruptcy, $request->validated());
            
            Log::info('Bankruptcy record updated', [
                'id' => $bankruptcy->id,
                'user_id' => auth()->id(),
                'changes' => array_diff_assoc($request->validated(), $oldData)
            ]);

            return $this->successResponse(
                new BankruptcyResource($bankruptcy),
                'Bankruptcy record updated successfully'
            );
            
        } catch (\Exception $e) {
            Log::error('Error updating bankruptcy', ['error' => $e->getMessage(), 'user' => auth()->id(), 'bankruptcy_id' => $bankruptcy->id]);
            return $this->errorResponse('Failed to update bankruptcy record', null, 500);
        }
    }

    public function destroy(Bankruptcy $bankruptcy): JsonResponse
    {
        try {
            $this->bankruptcyService->softDelete($bankruptcy);
            
            Log::warning('Bankruptcy record deleted', [
                'id' => $bankruptcy->id,
                'user_id' => auth()->id(),
                'insolvency_no' => $bankruptcy->insolvency_no
            ]);

            return $this->successResponse(null, 'Bankruptcy record deleted successfully');
            
        } catch (\Exception $e) {
            Log::error('Error deleting bankruptcy', ['error' => $e->getMessage(), 'user' => auth()->id(), 'bankruptcy_id' => $bankruptcy->id]);
            return $this->errorResponse('Failed to delete bankruptcy record', null, 500);
        }
    }

    public function search(SearchBankruptcyRequest $request): JsonResponse
    {
        try {
            $results = $this->bankruptcyService->search($request->validated());
            
            Log::info('Bankruptcy search performed', [
                'query' => $request->input('query'),
                'results_count' => $results->count(),
                'user_id' => auth()->id()
            ]);

            return $this->successResponse([
                'results' => BankruptcyResource::collection($results),
                'query' => $request->input('query'),
                'total' => $results->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in bankruptcy search', ['error' => $e->getMessage(), 'user' => auth()->id()]);
            return $this->errorResponse('Search failed', null, 500);
        }
    }
}
```

#### 6.3 API Resource for Consistent Response Format
```php
<?php
// app/Http/Resources/Api/BankruptcyResource.php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankruptcyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'insolvency_no' => $this->insolvency_no,
            'name' => $this->name,
            'ic_no' => $this->ic_no,
            'others' => $this->others,
            'court_case_no' => $this->court_case_no,
            'ro_date' => $this->ro_date?->format('Y-m-d'),
            'ao_date' => $this->ao_date?->format('Y-m-d'),
            'updated_date' => $this->updated_date,
            'branch' => $this->branch,
            'status' => $this->is_active ? 'active' : 'inactive',
            'formatted_updated_date' => $this->formatted_updated_date,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
```

### Step 7: Validation Requests

#### 7.1 Store Bankruptcy Request
```php
<?php
// app/Http/Requests/Api/StoreBankruptcyRequest.php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\ValidMalaysianIC;

class StoreBankruptcyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('create', \App\Models\Bankruptcy::class);
    }

    public function rules(): array
    {
        return [
            'insolvency_no' => 'required|string|max:50|unique:bankruptcies,insolvency_no',
            'name' => 'required|string|max:255|regex:/^[\pL\s\-\'\.]+$/u',
            'ic_no' => ['required', 'string', 'max:20', new ValidMalaysianIC(), 'unique:bankruptcies,ic_no'],
            'others' => 'nullable|string|max:255',
            'court_case_no' => 'nullable|string|max:100',
            'ro_date' => 'nullable|date|before_or_equal:today|after:1990-01-01',
            'ao_date' => 'nullable|date|before_or_equal:today|after:1990-01-01|after_or_equal:ro_date',
            'branch' => 'required|string|max:100',
            'is_active' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'The name may only contain letters, spaces, hyphens, apostrophes, and periods.',
            'ic_no.unique' => 'A bankruptcy record with this IC number already exists.',
            'insolvency_no.unique' => 'This insolvency number is already in use.',
            'ao_date.after_or_equal' => 'The AO date must be on or after the RO date.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'The given data was invalid.',
                    'details' => $validator->errors()
                ],
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => 'v1'
                ]
            ], 422)
        );
    }
}
```

#### 7.2 Custom Validation Rule
```php
<?php
// app/Rules/ValidMalaysianIC.php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidMalaysianIC implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Clean the IC number (remove spaces and dashes)
        $cleanIC = preg_replace('/[-\s]/', '', $value);
        
        // Check if it's exactly 12 digits
        if (!preg_match('/^\d{12}$/', $cleanIC)) {
            $fail('The :attribute must be a valid Malaysian IC number (12 digits).');
            return;
        }
        
        // Extract parts for additional validation
        $birthDate = substr($cleanIC, 0, 6);
        $birthPlace = substr($cleanIC, 6, 2);
        $gender = (int)substr($cleanIC, 11, 1);
        
        // Validate birth date format (YYMMDD)
        $year = substr($birthDate, 0, 2);
        $month = substr($birthDate, 2, 2);
        $day = substr($birthDate, 4, 2);
        
        // Determine century (Malaysian IC logic)
        $fullYear = ((int)$year <= 30) ? 2000 + (int)$year : 1900 + (int)$year;
        
        if (!checkdate((int)$month, (int)$day, $fullYear)) {
            $fail('The :attribute contains an invalid birth date.');
            return;
        }
        
        // Validate birth place code (01-16 for Malaysian states)
        $birthPlaceCode = (int)$birthPlace;
        if ($birthPlaceCode < 1 || $birthPlaceCode > 16) {
            $fail('The :attribute contains an invalid Malaysian state code.');
            return;
        }
    }
}
```

---

## Phase 3: Advanced Features & Security

### Step 8: Universal Search Implementation

#### 8.1 Universal Search Controller
```php
<?php
// app/Http/Controllers/Api/V1/SearchController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\UniversalSearchRequest;
use App\Services\UniversalSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SearchController extends BaseApiController
{
    public function __construct(
        private UniversalSearchService $searchService
    ) {}

    public function search(UniversalSearchRequest $request): JsonResponse
    {
        try {
            $results = $this->searchService->search($request->validated());
            
            Log::info('Universal search performed', [
                'query' => $request->input('query'),
                'type' => $request->input('type', 'auto'),
                'results_count' => count($results['results']),
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);

            return $this->successResponse($results, 'Search completed successfully');
            
        } catch (\Exception $e) {
            Log::error('Universal search error', [
                'error' => $e->getMessage(),
                'user' => auth()->id(),
                'query' => $request->input('query')
            ]);
            
            return $this->errorResponse('Search failed', null, 500);
        }
    }

    public function advanced(AdvancedSearchRequest $request): JsonResponse
    {
        try {
            $results = $this->searchService->advancedSearch($request->validated());
            
            Log::info('Advanced search performed', [
                'filters' => $request->input('filters', []),
                'results_count' => $results->total(),
                'user_id' => auth()->id()
            ]);

            return $this->successResponse($results);
            
        } catch (\Exception $e) {
            Log::error('Advanced search error', [
                'error' => $e->getMessage(),
                'user' => auth()->id()
            ]);
            
            return $this->errorResponse('Advanced search failed', null, 500);
        }
    }
}
```

### Step 9: Audit Logging System

#### 9.1 Audit Log Model
```php
<?php
// app/Models/AuditLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'resource_type',
        'resource_id',
        'ip_address',
        'user_agent',
        'changes'
    ];

    protected $casts = [
        'changes' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

#### 9.2 Audit Middleware
```php
<?php
// app/Http/Middleware/AuditMiddleware.php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuditMiddleware
{
    private array $auditableActions = ['POST', 'PUT', 'PATCH', 'DELETE'];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only audit specific actions and successful responses
        if (
            in_array($request->method(), $this->auditableActions) &&
            $response->getStatusCode() < 400 &&
            auth()->check()
        ) {
            $this->createAuditLog($request, $response);
        }

        return $response;
    }

    private function createAuditLog(Request $request, Response $response): void
    {
        try {
            $action = $this->determineAction($request);
            $resourceInfo = $this->extractResourceInfo($request);
            
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'resource_type' => $resourceInfo['type'],
                'resource_id' => $resourceInfo['id'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'changes' => $this->extractChanges($request, $response)
            ]);
        } catch (\Exception $e) {
            Log::error('Audit logging failed', ['error' => $e->getMessage()]);
        }
    }

    private function determineAction(Request $request): string
    {
        return match($request->method()) {
            'POST' => 'CREATE',
            'PUT', 'PATCH' => 'UPDATE',
            'DELETE' => 'DELETE',
            default => 'UNKNOWN'
        };
    }

    private function extractResourceInfo(Request $request): array
    {
        $path = $request->path();
        
        // Extract resource type and ID from API paths like api/v1/bankruptcies/123
        if (preg_match('/api\/v1\/(\w+)(?:\/(\d+))?/', $path, $matches)) {
            return [
                'type' => $matches[1] ?? 'unknown',
                'id' => $matches[2] ?? null
            ];
        }
        
        return ['type' => 'unknown', 'id' => null];
    }

    private function extractChanges(Request $request, Response $response): array
    {
        $changes = ['input' => $request->except(['password', 'password_confirmation', '_token'])];
        
        // Try to extract response data for CREATE operations
        if ($request->method() === 'POST' && $response->getStatusCode() === 201) {
            $responseData = json_decode($response->getContent(), true);
            if (isset($responseData['data'])) {
                $changes['created'] = $responseData['data'];
            }
        }
        
        return $changes;
    }
}
```

### Step 10: Branch Creation Strategy

#### 10.1 Create Security Testing Branch
```bash
# Git commands to create security testing branch
git checkout -b security-testing
git push -u origin security-testing
```

#### 10.2 Additional Debug Routes (Security Testing Branch Only)
```php
<?php
// routes/api/debug.php (only in security-testing branch)

use App\Http\Controllers\Api\V1\DebugController;

Route::middleware(['auth:sanctum', 'admin'])->prefix('debug')->name('debug.')->group(function () {
    Route::get('/tokens', [DebugController::class, 'listTokens'])->name('tokens');
    Route::get('/permissions', [DebugController::class, 'listPermissions'])->name('permissions');
    Route::get('/logs', [DebugController::class, 'getSecurityLogs'])->name('logs');
    Route::get('/user-sessions', [DebugController::class, 'getUserSessions'])->name('user-sessions');
    Route::post('/simulate-attack', [DebugController::class, 'simulateAttack'])->name('simulate-attack');
});
```

---

## Next Steps Summary

1. **Immediate Implementation**: Start with Phase 1 (Core API Infrastructure)
2. **Progressive Development**: Move through phases systematically
3. **Security Focus**: Implement comprehensive logging and monitoring
4. **Testing Preparation**: Create separate branch for security testing
5. **Documentation**: Generate OpenAPI/Swagger documentation
6. **Performance Optimization**: Add caching and query optimization
7. **Monitoring Setup**: Implement health checks and performance monitoring

This roadmap provides a solid foundation for building a secure, comprehensive API for the Laravel Insolvency System while preparing for penetration testing without compromising production security.