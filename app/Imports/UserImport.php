<?php

namespace App\Imports;

use App\Models\User;
use App\Services\AuditService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class UserImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading, WithMapping, SkipsOnFailure
{
    use SkipsFailures;
    /**
     * Convert various boolean formats to proper boolean values
     */
    private function convertToBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            $value = strtolower(trim($value));
            if (in_array($value, ['true', '1', 'yes', 'y', 'on', 'active', 'enabled'])) {
                return true;
            }
            if (in_array($value, ['false', '0', 'no', 'n', 'off', 'inactive', 'disabled'])) {
                return false;
            }
        }
        
        if (is_numeric($value)) {
            return (int) $value === 1;
        }
        
        // Default to true for any other value
        return true;
    }

    public function model(array $row)
    {
        // Remove id from row data to prevent manual ID assignment
        unset($row['id']);
        
        // Convert staff_id to string and handle empty values
        $staffId = !empty($row['staff_id']) ? (string) $row['staff_id'] : null;
        
        // If staff_id exists, update the existing user instead of creating new one
        if ($staffId) {
            $existingUser = User::where('login_id', $staffId)->first();
            if ($existingUser) {
                $oldValues = $existingUser->getAttributes();
                
                $existingUser->update([
                    'name' => $row['name'],
                    'role' => $row['role'] ?? $existingUser->role,
                    'branch_code' => !empty($row['branch_code']) ? (string) $row['branch_code'] : $existingUser->branch_code,
                    'status' => $row['status'] ?? $existingUser->status,
                    'is_active' => $this->convertToBoolean($row['is_active'] ?? $existingUser->is_active),
                    'last_modified_date' => now(),
                    'last_modified_user' => auth()->user()->name ?? 'System',
                ]);
                
                // Update password if provided
                if (!empty($row['password'])) {
                    $existingUser->update([
                        'password' => Hash::make($row['password']),
                        'pwdchange_date' => now(),
                    ]);
                }
                
                // Log the bulk update
                if (auth()->check()) {
                    AuditService::log(
                        auth()->user(),
                        'BULK_UPDATE',
                        "Bulk updated user: {$existingUser->name} (Staff ID: {$staffId})",
                        $existingUser,
                        $oldValues,
                        $existingUser->fresh()->getAttributes(),
                        request(),
                        ['source' => 'bulk_upload', 'staff_id' => $staffId]
                    );
                }
                
                return null; // Don't create a new user
            }
        }
        
        $newUser = new User([
            'name' => $row['name'],
            'login_id' => $staffId,
            'password' => Hash::make($row['password'] ?? 'password123'), // Default password
            'role' => $row['role'] ?? 'staff',
            'branch_code' => !empty($row['branch_code']) ? (string) $row['branch_code'] : null,
            'status' => $row['status'] ?? 'active',
            'is_active' => $this->convertToBoolean($row['is_active'] ?? true),
        ]);
        
        // Log the bulk creation after the user is saved
        if (auth()->check()) {
            $newUser->save();
            AuditService::log(
                auth()->user(),
                'BULK_CREATE',
                "Bulk created user: {$newUser->name} (Staff ID: {$staffId})",
                $newUser,
                null,
                $newUser->getAttributes(),
                request(),
                ['source' => 'bulk_upload', 'staff_id' => $staffId]
            );
        }
        
        return $newUser;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'staff_id' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:superuser,admin,id_management,staff',
            'branch_code' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:active,inactive,suspended,expired',
            'is_active' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'The name field is required.',
            'role.required' => 'The role field is required. Valid values: superuser, admin, id_management, staff',
            'role.in' => 'The role must be one of: superuser, admin, id_management, staff',
            'status.in' => 'The status must be one of: active, inactive, suspended, expired',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function map($row): array
    {
        // Map Excel column names to our expected field names
        // Laravel Excel converts "Staff ID" to "staff_id", "Branch Code" to "branch_code", etc.
        return [
            'name' => $row['name'] ?? null,
            'staff_id' => $row['staff_id'] ?? $row['staff id'] ?? null,
            'password' => $row['password'] ?? null,
            'role' => $row['role'] ?? $row['role (superuser/admin/id_management/staff)'] ?? null,
            'branch_code' => $row['branch_code'] ?? $row['branch code'] ?? null,
            'status' => $row['status'] ?? $row['status (active/inactive/suspended/expired)'] ?? null,
            'is_active' => $row['is_active'] ?? $row['is active (true/false)'] ?? null,
        ];
    }
}
