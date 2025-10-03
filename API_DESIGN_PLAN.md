# Laravel Insolvency System - Comprehensive API Design Plan

## Project Analysis Summary

Based on the analysis of the Laravel Insolvency System, this is a government/legal system for managing insolvency cases in Malaysia, handling:

- **Individual Bankruptcies**: Personal insolvency cases with IC numbers
- **Annulment Records**: Individual case annulments/releases  
- **Non-Individual Bankruptcies**: Corporate insolvency cases with company registration numbers
- **User Management**: Admin and regular users with role-based access

### Current System Architecture
- **Framework**: Laravel 10+ with Sanctum authentication
- **Database**: MySQL with 3 main entities (Users, Bankruptcies, AnnulmentIndv, NonIndividualBankruptcy)
- **Authentication**: Session-based with role-based access (admin/user)
- **Current API**: Minimal API routes (only user endpoint)

---

## Comprehensive API Architecture Design

### 1. Authentication & Authorization Strategy

#### API Authentication Methods
```php
// Multiple authentication options for flexibility
'guards' => [
    'web' => ['driver' => 'session', 'provider' => 'users'],
    'api' => ['driver' => 'sanctum', 'provider' => 'users'],
    'api-token' => ['driver' => 'token', 'provider' => 'users'], // For external systems
]
```

#### Token-based Authentication (Sanctum)
- Personal Access Tokens for external integrations
- API tokens with scoped permissions
- Stateful SPA authentication for frontend apps

#### Role-based Authorization
- **Public Access**: Search functionality (limited)
- **User Role**: Read-only access to records
- **Admin Role**: Full CRUD operations, user management, bulk operations

### 2. RESTful API Endpoint Design

#### Base API Structure
```
GET    /api/v1/health              # Health check
POST   /api/v1/auth/login          # Authentication
POST   /api/v1/auth/logout         # Logout
POST   /api/v1/auth/refresh        # Refresh token
GET    /api/v1/auth/user           # Current user info
```

#### User Management Endpoints
```
GET    /api/v1/users               # List users (admin only)
POST   /api/v1/users               # Create user (admin only)
GET    /api/v1/users/{id}          # Get user details
PUT    /api/v1/users/{id}          # Update user
DELETE /api/v1/users/{id}          # Deactivate user (admin only)
PUT    /api/v1/users/{id}/activate # Activate user (admin only)
POST   /api/v1/users/change-password # Change password
```

#### Individual Bankruptcy Endpoints
```
GET    /api/v1/bankruptcies            # List individual bankruptcies
POST   /api/v1/bankruptcies            # Create bankruptcy record
GET    /api/v1/bankruptcies/{id}       # Get bankruptcy details
PUT    /api/v1/bankruptcies/{id}       # Update bankruptcy record
DELETE /api/v1/bankruptcies/{id}       # Soft delete bankruptcy record
POST   /api/v1/bankruptcies/bulk       # Bulk import
GET    /api/v1/bankruptcies/export     # Export records
POST   /api/v1/bankruptcies/search     # Advanced search
```

#### Annulment Records Endpoints
```
GET    /api/v1/annulments              # List annulment records
POST   /api/v1/annulments              # Create annulment record
GET    /api/v1/annulments/{id}         # Get annulment details
PUT    /api/v1/annulments/{id}         # Update annulment record
DELETE /api/v1/annulments/{id}         # Soft delete annulment record
POST   /api/v1/annulments/bulk         # Bulk import
GET    /api/v1/annulments/export       # Export records
POST   /api/v1/annulments/search       # Advanced search
```

#### Non-Individual Bankruptcy Endpoints
```
GET    /api/v1/corporate-bankruptcies      # List corporate bankruptcies
POST   /api/v1/corporate-bankruptcies      # Create corporate bankruptcy
GET    /api/v1/corporate-bankruptcies/{id} # Get corporate bankruptcy details
PUT    /api/v1/corporate-bankruptcies/{id} # Update corporate bankruptcy
DELETE /api/v1/corporate-bankruptcies/{id} # Soft delete corporate bankruptcy
POST   /api/v1/corporate-bankruptcies/bulk # Bulk import
GET    /api/v1/corporate-bankruptcies/export # Export records
POST   /api/v1/corporate-bankruptcies/search # Advanced search
```

#### Universal Search Endpoints
```
POST   /api/v1/search                  # Universal search across all records
POST   /api/v1/search/advanced         # Advanced search with filters
GET    /api/v1/search/suggestions      # Search suggestions/autocomplete
```

#### Statistics & Reports Endpoints
```
GET    /api/v1/statistics              # System statistics
GET    /api/v1/statistics/dashboard    # Dashboard data
GET    /api/v1/reports/summary         # Summary reports
GET    /api/v1/reports/custom          # Custom reports with filters
```

#### System Management Endpoints (Admin only)
```
GET    /api/v1/admin/system-info       # System information
GET    /api/v1/admin/audit-logs        # Audit trail
POST   /api/v1/admin/backup            # Trigger backup
GET    /api/v1/admin/settings          # System settings
PUT    /api/v1/admin/settings          # Update system settings
```

### 3. Security Implementation

#### Input Validation & Sanitization
```php
// Custom Form Requests for each endpoint
class StoreBankruptcyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('create', Bankruptcy::class);
    }

    public function rules(): array
    {
        return [
            'insolvency_no' => 'required|string|unique:bankruptcies',
            'name' => 'required|string|max:255|regex:/^[\pL\s\-\'\.]+$/u',
            'ic_no' => 'required|string|regex:/^\d{6}-\d{2}-\d{4}$/',
            // Additional validation rules...
        ];
    }
}
```

#### Rate Limiting
```php
// Different rate limits for different endpoints
Route::middleware(['throttle:search'])->group(function () {
    Route::post('/search', [SearchController::class, 'search']);
});

Route::middleware(['throttle:api'])->group(function () {
    Route::apiResource('bankruptcies', BankruptcyController::class);
});
```

#### SQL Injection Prevention
- Use Eloquent ORM and Query Builder
- Parameterized queries for raw SQL
- Input sanitization and validation

#### XSS Prevention
- API responses in JSON format (not HTML)
- Input validation and sanitization
- Output encoding when necessary

#### CSRF Protection
- CSRF tokens for stateful requests
- SameSite cookies configuration
- Proper CORS configuration

### 4. Data Validation & Business Logic

#### Validation Rules
```php
// IC Number validation (Malaysian format)
'ic_no' => [
    'required',
    'string',
    'regex:/^\d{6}-\d{2}-\d{4}$/',
    new ValidMalaysianIC()
]

// Company Registration Number validation
'company_registration_no' => [
    'required',
    'string',
    'regex:/^(19|20)\d{2}\d{6,8}$/',
    new ValidCompanyRegistration()
]

// Date validation with business logic
'ro_date' => [
    'required',
    'date',
    'before_or_equal:today',
    'after:1990-01-01'
]
```

#### Business Rules Implementation
- Unique constraints on IC numbers and company registration numbers
- Date logical validation (e.g., discharge date after bankruptcy date)
- Status transitions validation
- Branch-specific access controls

### 5. Response Format Standardization

#### Success Response Format
```json
{
    "success": true,
    "data": {
        "id": 1,
        "insolvency_no": "BKR001",
        "name": "John Doe",
        // ... other fields
    },
    "message": "Record retrieved successfully",
    "meta": {
        "timestamp": "2025-01-03T00:59:39Z",
        "version": "v1"
    }
}
```

#### Error Response Format
```json
{
    "success": false,
    "error": {
        "code": "VALIDATION_ERROR",
        "message": "The given data was invalid.",
        "details": {
            "ic_no": ["The IC number format is invalid."],
            "name": ["The name field is required."]
        }
    },
    "meta": {
        "timestamp": "2025-01-03T00:59:39Z",
        "version": "v1"
    }
}
```

#### Pagination Response Format
```json
{
    "success": true,
    "data": [...],
    "meta": {
        "current_page": 1,
        "per_page": 20,
        "total": 150,
        "last_page": 8,
        "from": 1,
        "to": 20
    },
    "links": {
        "first": "/api/v1/bankruptcies?page=1",
        "last": "/api/v1/bankruptcies?page=8",
        "prev": null,
        "next": "/api/v1/bankruptcies?page=2"
    }
}
```

### 6. Advanced Features

#### Search Capabilities
```php
// Universal search across all record types
POST /api/v1/search
{
    "query": "123456-78-9012",
    "type": "auto", // auto-detect, ic_number, company_registration, name
    "filters": {
        "record_types": ["bankruptcy", "annulment", "corporate"],
        "date_range": {
            "from": "2023-01-01",
            "to": "2024-12-31"
        },
        "branch": "KL",
        "status": "active"
    },
    "sort": {
        "field": "updated_date",
        "direction": "desc"
    },
    "pagination": {
        "page": 1,
        "per_page": 20
    }
}
```

#### Bulk Operations
```php
// Bulk import with validation
POST /api/v1/bankruptcies/bulk
{
    "records": [...],
    "options": {
        "skip_duplicates": true,
        "validate_only": false,
        "batch_size": 100
    }
}
```

#### Export Functionality
```php
// Export with filters
GET /api/v1/bankruptcies/export?format=excel&filters[branch]=KL&date_from=2024-01-01
```

### 7. Monitoring & Logging

#### API Monitoring
- Request/response logging
- Performance monitoring
- Error tracking and alerting
- Usage analytics

#### Audit Trail
```php
// Audit log for sensitive operations
{
    "user_id": 1,
    "action": "CREATE_BANKRUPTCY_RECORD",
    "resource": "bankruptcies",
    "resource_id": 123,
    "ip_address": "192.168.1.1",
    "user_agent": "API Client v1.0",
    "timestamp": "2025-01-03T00:59:39Z",
    "changes": {
        "before": null,
        "after": {...}
    }
}
```

---

## Implementation Strategy

### Phase 1: Core API Infrastructure (Week 1-2)
1. Set up API versioning and routing structure
2. Implement authentication middleware and token management
3. Create base controller with standardized responses
4. Set up input validation and error handling
5. Configure rate limiting and security middleware

### Phase 2: CRUD Operations (Week 3-4)
1. Implement bankruptcy records API endpoints
2. Implement annulment records API endpoints  
3. Implement corporate bankruptcy API endpoints
4. Add comprehensive validation rules
5. Create API resources for consistent response formatting

### Phase 3: Advanced Features (Week 5-6)
1. Implement universal search functionality
2. Add bulk import/export capabilities
3. Create statistics and reporting endpoints
4. Implement audit logging
5. Add advanced filtering and sorting

### Phase 4: Testing & Documentation (Week 7-8)
1. Write comprehensive API tests
2. Set up automated testing pipeline
3. Create API documentation (OpenAPI/Swagger)
4. Perform security testing
5. Load testing and optimization

### Phase 5: Production Readiness (Week 9-10)
1. Set up monitoring and logging
2. Configure caching strategies
3. Implement backup and recovery procedures
4. Security hardening and penetration testing preparation
5. Deployment and staging environment setup

---

## Security Considerations for Penetration Testing

### Intentional Security Features (Not Vulnerabilities)
To prepare for penetration testing without compromising the system, we'll implement:

1. **Comprehensive Logging**: All API requests logged for security analysis
2. **Input Validation**: Strict validation to test bypass attempts
3. **Rate Limiting**: Robust rate limiting to test circumvention methods
4. **Authentication**: Multiple authentication methods to test different attack vectors
5. **Authorization**: Granular permission system to test privilege escalation
6. **Error Handling**: Detailed error responses for debugging (can be tuned for production)

### Security Testing Branch Strategy
- Create a dedicated `security-testing` branch
- Include additional debugging endpoints for security testing
- Enhanced logging for security analysis
- Configurable security settings for different testing scenarios

### Testing-Friendly Features
```php
// Debugging endpoints (testing branch only)
Route::middleware(['auth:api', 'admin'])->prefix('debug')->group(function () {
    Route::get('/tokens', [DebugController::class, 'listTokens']);
    Route::get('/permissions', [DebugController::class, 'listPermissions']);
    Route::get('/logs', [DebugController::class, 'getSecurityLogs']);
});
```

This comprehensive API design provides a robust foundation for the Laravel Insolvency System while maintaining security best practices and preparing for thorough security testing.