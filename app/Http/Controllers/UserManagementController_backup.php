<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditService;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withTrashed();
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('login_id', 'like', "%{$searchTerm}%")
                  ->orWhere('branch_code', 'like', "%{$searchTerm}%")
                  ->orWhere('role', 'like', "%{$searchTerm}%")
                  ->orWhere('status', 'like', "%{$searchTerm}%");
            });
        }
        
        // Filter by role if specified
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }
        
        // Filter by status if specified
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        
        // Show only active users (no deleted users)
        $query->whereNull('deleted_at');
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Log search action if search term is provided
        if ($request->filled('search')) {
            AuditService::logSearch(
                auth()->user(), 
                $request->get('search'), 
                'User', 
                $users->total(), 
                $request
            );
        }
        
        // Log view action for user management page
        AuditService::log(
            auth()->user(),
            'VIEW',
            'Accessed user management page',
            null,
            null,
            null,
            $request,
            [
                'page' => 'user_management',
                'filters' => [
                    'search' => $request->get('search'),
                    'role' => $request->get('role'),
                    'status' => $request->get('status')
                ],
                'total_results' => $users->total()
            ]
        );
        
        return view('user-management.index', compact('users'));
    }

    public function create()
    {
        // Log the create page view
        AuditService::log(
            auth()->user(),
            'VIEW',
            'Accessed user creation page',
            null,
            null,
            null,
            request(),
            ['page' => 'user_create']
        );
        
        return view('user-management.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'login_id' => ['nullable', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:superuser,admin,id_management,staff'],
            'branch_code' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'in:active,inactive,suspended,expired'],
            'expiry_date' => ['nullable', 'date', 'after:today'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'login_id' => $request->login_id,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'branch_code' => $request->branch_code,
            'status' => $request->status ?? 'active',
            'expiry_date' => $request->expiry_date,
            'pwdchange_date' => now(),
            'last_modified_date' => now(),
            'last_modified_user' => auth()->user()->name,
        ]);

        // Log the user creation
        AuditService::logUserCreation(auth()->user(), $user, $request);

        return redirect()->route('user-management.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        // Log the user view
        AuditService::logView(auth()->user(), $user, request());
        
        return view('user-management.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Log the edit page view
        AuditService::log(
            auth()->user(),
            'VIEW',
            "Accessed user edit page for: {$user->name}",
            $user,
            null,
            null,
            request(),
            ['page' => 'user_edit', 'target_user' => $user->name]
        );
        
        return view('user-management.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'login_id' => ['nullable', 'string', 'max:255', 'unique:users,login_id,' . $user->id],
            'role' => ['required', 'string', 'in:superuser,admin,id_management,staff'],
            'branch_code' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'in:active,inactive,suspended,expired'],
            'expiry_date' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Store old values for audit log
        $oldValues = $user->getAttributes();

        $user->update([
            'name' => $request->name,
            'login_id' => $request->login_id,
            'role' => $request->role,
            'branch_code' => $request->branch_code,
            'status' => $request->status ?? 'active',
            'expiry_date' => $request->expiry_date,
            'last_modified_date' => now(),
            'last_modified_user' => auth()->user()->name,
        ]);

        // Log the user update
        AuditService::logUserUpdate(auth()->user(), $user, $oldValues, $request);

        return redirect()->route('user-management.index')
            ->with('success', 'User updated successfully.');
    }


    public function changePassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'pwdchange_date' => now(),
            'last_modified_date' => now(),
            'last_modified_user' => auth()->user()->name,
        ]);

        // Log the password change
        AuditService::logPasswordChange(auth()->user(), $user, $request);

        return redirect()->route('user-management.index')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('user-management.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Log the deletion before deleting
        AuditService::logUserDeletion(auth()->user(), $user, request());

        // Soft delete the user
        $user->delete();

        return redirect()->route('user-management.index')
            ->with('success', 'User deleted successfully.');
    }

    public function bulkUpload()
    {
        // Log the bulk upload page view
        AuditService::log(
            auth()->user(),
            'VIEW',
            'Accessed bulk upload page',
            null,
            null,
            null,
            request(),
            ['page' => 'user_bulk_upload']
        );
        
        return view('user-management.bulk-upload');
    }

    public function processBulkUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('excel_file');
            
            // Import users from Excel
            Excel::import(new UserImport, $file);
            
            // Count imported users (this is a simplified count)
            $importedCount = User::where('created_at', '>=', now()->subMinutes(5))->count();
            
            // Log the bulk upload
            AuditService::logBulkUpload(auth()->user(), 'User', $importedCount, $request);
            
            return redirect()->route('user-management.index')
                ->with('success', 'Users uploaded successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error uploading users: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function downloadTemplate()
    {
        // Log the template download
        AuditService::logDownload(
            auth()->user(),
            'user_template',
            'user_template.xlsx',
            request()
        );
        
        return Excel::download(new UserTemplateExport, 'user_template.xlsx');
    }

    public function downloadUsers()
    {
        $userCount = User::withTrashed()->count();
        
        // Log the bulk download
        AuditService::logBulkDownload(auth()->user(), 'User', $userCount, request());
        
        return Excel::download(new UserExport, 'users_' . date('Y-m-d_H-i-s') . '.xlsx');
    }
}
{
    /**
     * Convert various boolean formats to proper boolean values
     */
    private function convertToBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_null($value) || $value === '') {
            return true; // Default to true if empty
        }
        
        $value = strtolower(trim((string) $value));
        
        // Handle various true values
        if (in_array($value, ['1', 'true', 'yes', 'y', 'on', 'active', 'enabled'])) {
            return true;
        }
        
        // Handle various false values
        if (in_array($value, ['0', 'false', 'no', 'n', 'off', 'inactive', 'disabled'])) {
            return false;
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
            'staff_id' => 'nullable|max:255',
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:superuser,admin,id_management,staff',
            'branch_code' => 'nullable|max:255',
            'status' => 'nullable|in:active,inactive,suspended,expired',
            'is_active' => 'nullable',
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
        // Only map the columns we want to process, excluding 'id'
        return [
            'name' => $row['name'] ?? null,
            'staff_id' => $row['staff_id'] ?? null,
            'password' => $row['password'] ?? null,
            'role' => $row['role'] ?? null,
            'branch_code' => $row['branch_code'] ?? null,
            'status' => $row['status'] ?? null,
            'is_active' => $row['is_active'] ?? null,
        ];
    }
}

// User Export Class
class UserExport implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings
{
    public function collection()
    {
        return User::withTrashed()->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'staff_id' => $user->login_id ?: 'N/A',
                'branch_code' => $user->branch_code ?: 'N/A',
                'role' => $user->role,
                'status' => $user->status ?: 'N/A',
                'is_active' => $user->is_active ? 'Yes' : 'No',
                'expiry_date' => $user->expiry_date ? $user->expiry_date->format('Y-m-d') : 'N/A',
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'deleted_at' => $user->deleted_at ? $user->deleted_at->format('Y-m-d H:i:s') : null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Staff ID',
            'Branch Code',
            'Role',
            'Status',
            'Is Active',
            'Expiry Date',
            'Created At',
            'Updated At',
            'Deleted At',
        ];
    }
}

// User Template Export Class
class UserTemplateExport implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings
{
    public function array(): array
    {
        return [
            [
                'John Doe',
                'STAFF001',
                'BR001',
                'password123',
                'staff',
                'active',
                true,
            ],
            [
                'Jane Smith',
                'ADMIN001',
                'BR002',
                'password123',
                'admin',
                'active',
                true,
            ],
            [
                'Bob Wilson',
                'IDM001',
                'BR001',
                'password123',
                'id_management',
                'active',
                true,
            ],
            [
                'Alice Johnson',
                'SUPER001',
                'BR000',
                'password123',
                'superuser',
                'active',
                true,
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Staff ID',
            'Branch Code',
            'Password',
            'Role (superuser/admin/id_management/staff)',
            'Status (active/inactive/suspended/expired)',
            'Is Active (true/false)',
        ];
    }
}
