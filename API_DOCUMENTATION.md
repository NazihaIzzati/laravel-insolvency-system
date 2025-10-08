# Laravel Insolvency System API Documentation

## Overview
The Laravel Insolvency System provides a comprehensive RESTful API for managing bankruptcy, annulment, and corporate bankruptcy records. The API uses Laravel Sanctum for authentication and follows REST conventions.

## Base URL
```
http://laravel-insolvency-system.test/api/v1
```

## Authentication
All API endpoints (except login/register) require Bearer token authentication.

### Login
```bash
POST /auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "role": "admin"
    },
    "token": "12|xyz123...",
    "token_type": "Bearer"
  }
}
```

### Using the Token
Include the token in the Authorization header for all subsequent requests:
```bash
Authorization: Bearer {token}
```

## API Endpoints

### 1. Individual Bankruptcy Records

#### List Bankruptcies
```bash
GET /bankruptcies?page=1&per_page=20&search=keyword&branch=location
```

**Query Parameters:**
- `page` (optional): Page number (default: 1)
- `per_page` (optional): Items per page, max 100 (default: 20)
- `search` (optional): Search across name, IC number, insolvency number, court case number
- `branch` (optional): Filter by branch location

#### Get Single Bankruptcy
```bash
GET /bankruptcies/{id}
```

#### Create Bankruptcy (Admin Only)
```bash
POST /bankruptcies
Content-Type: application/json

{
  "insolvency_no": "INS999",
  "name": "John Doe",
  "ic_no": "123456789012",
  "others": "Business description",
  "court_case_no": "BC2024999",
  "ro_date": "2024-01-15",
  "ao_date": "2024-02-15",
  "branch": "Kuala Lumpur"
}
```

#### Update Bankruptcy (Admin Only)
```bash
PUT /bankruptcies/{id}
Content-Type: application/json

{
  "insolvency_no": "INS999",
  "name": "John Doe Updated",
  "ic_no": "123456789012",
  "others": "Updated business description",
  "court_case_no": "BC2024999",
  "ro_date": "2024-01-15",
  "ao_date": "2024-02-15",
  "branch": "Selangor"
}
```

#### Delete Bankruptcy (Admin Only)
```bash
DELETE /bankruptcies/{id}
```

### 2. Annulment Records

#### List Annulments
```bash
GET /annulments?page=1&per_page=20&search=keyword&branch=location&release_type=type
```

**Query Parameters:**
- `page` (optional): Page number
- `per_page` (optional): Items per page, max 100
- `search` (optional): Search across name, IC number, court case number
- `branch` (optional): Filter by branch location
- `release_type` (optional): Filter by release type (Annulment, Discharge)

#### Get Single Annulment
```bash
GET /annulments/{id}
```

#### Create Annulment (Admin Only)
```bash
POST /annulments
Content-Type: application/json

{
  "name": "Jane Smith",
  "ic_no": "987654321098",
  "others": "Sales Executive",
  "court_case_no": "CC2024999",
  "release_date": "2024-03-15",
  "release_type": "Annulment",
  "branch": "Penang Branch"
}
```

#### Update Annulment (Admin Only)
```bash
PUT /annulments/{id}
Content-Type: application/json
```

#### Delete Annulment (Admin Only)
```bash
DELETE /annulments/{id}
```

### 3. Corporate Bankruptcy Records

#### List Corporate Bankruptcies
```bash
GET /corporate-bankruptcies?page=1&per_page=20&search=keyword&branch=location
```

**Query Parameters:**
- `page` (optional): Page number
- `per_page` (optional): Items per page, max 100
- `search` (optional): Search across company name, registration number, insolvency number, court case number
- `branch` (optional): Filter by branch location

#### Get Single Corporate Bankruptcy
```bash
GET /corporate-bankruptcies/{id}
```

#### Create Corporate Bankruptcy (Admin Only)
```bash
POST /corporate-bankruptcies
Content-Type: application/json

{
  "insolvency_no": "NIINS999",
  "company_name": "Test Corporation Sdn Bhd",
  "company_registration_no": "202399999999",
  "others": "Testing services",
  "court_case_no": "WU2024999",
  "date_of_winding_up_resolution": "2024-08-01",
  "branch": "Kuala Lumpur"
}
```

#### Update Corporate Bankruptcy (Admin Only)
```bash
PUT /corporate-bankruptcies/{id}
Content-Type: application/json
```

#### Delete Corporate Bankruptcy (Admin Only)
```bash
DELETE /corporate-bankruptcies/{id}
```

### 4. User Management

#### List Users (Admin Only)
```bash
GET /users?page=1&per_page=20&search=keyword&role=admin
```

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    // Response data here
  },
  "meta": {
    "timestamp": "2025-10-06T01:37:38.320387Z",
    "version": "v1"
  }
}
```

### Paginated Response
```json
{
  "success": true,
  "message": "Records retrieved successfully",
  "data": {
    "data": [...],
    "meta": {
      "current_page": 1,
      "per_page": 20,
      "total": 100,
      "last_page": 5,
      "from": 1,
      "to": 20
    },
    "links": {
      "first": "http://example.com/api/v1/bankruptcies?page=1",
      "last": "http://example.com/api/v1/bankruptcies?page=5",
      "prev": null,
      "next": "http://example.com/api/v1/bankruptcies?page=2"
    }
  },
  "meta": {
    "timestamp": "2025-10-06T01:37:38.320387Z",
    "version": "v1"
  }
}
```

### Error Response
```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "The given data was invalid.",
    "details": {
      "field_name": ["Field is required"]
    }
  },
  "meta": {
    "timestamp": "2025-10-06T01:37:38.320387Z",
    "version": "v1"
  }
}
```

## HTTP Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request (Validation Error)
- `401` - Unauthorized (Authentication Required)
- `403` - Forbidden (Insufficient Permissions)
- `404` - Not Found
- `422` - Unprocessable Entity (Validation Failed)
- `500` - Internal Server Error

## Rate Limiting

Authentication endpoints are rate limited to 60 requests per minute per IP address.

## Examples

### Complete Workflow Example
```bash
# 1. Login
curl -X POST -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password123"}' \
  http://laravel-insolvency-system.test/api/v1/auth/login

# 2. Search corporate bankruptcies
curl -H "Authorization: Bearer 12|xyz..." \
  "http://laravel-insolvency-system.test/api/v1/corporate-bankruptcies?search=Tech&branch=Selangor"

# 3. Get specific record
curl -H "Authorization: Bearer 12|xyz..." \
  http://laravel-insolvency-system.test/api/v1/bankruptcies/1

# 4. Create new record (admin only)
curl -X POST -H "Authorization: Bearer 12|xyz..." \
  -H "Content-Type: application/json" \
  -d '{"insolvency_no":"INS999","name":"John Doe","ic_no":"123456789012","others":"Business Owner","court_case_no":"BC2024999","ro_date":"2024-01-15","ao_date":"2024-02-15","branch":"Kuala Lumpur"}' \
  http://laravel-insolvency-system.test/api/v1/bankruptcies
```

## Field Validation Rules

### Bankruptcy Records
- `insolvency_no`: Required, unique, max 50 characters
- `name`: Required, max 255 characters
- `ic_no`: Required, unique, max 20 characters
- `others`: Optional, max 255 characters
- `court_case_no`: Optional, max 100 characters
- `ro_date`: Optional, valid date, before or equal to today
- `ao_date`: Optional, valid date, before or equal to today
- `branch`: Required, max 100 characters

### Annulment Records
- `name`: Required, max 255 characters
- `ic_no`: Required, unique, max 20 characters
- `others`: Optional, max 255 characters
- `court_case_no`: Optional, max 100 characters
- `release_date`: Optional, valid date, before or equal to today
- `release_type`: Optional, max 50 characters
- `branch`: Required, max 100 characters

### Corporate Bankruptcy Records
- `insolvency_no`: Required, unique, max 50 characters
- `company_name`: Required, max 255 characters
- `company_registration_no`: Required, unique, max 50 characters
- `others`: Optional, max 255 characters
- `court_case_no`: Optional, max 100 characters
- `date_of_winding_up_resolution`: Optional, valid date, before or equal to today
- `branch`: Required, max 100 characters

## Security Notes

- All data modification operations require admin role
- Tokens expire after configured time period
- All deletions are soft deletes (data preserved)
- Input validation prevents SQL injection and XSS attacks
- CORS headers configured for cross-origin requests