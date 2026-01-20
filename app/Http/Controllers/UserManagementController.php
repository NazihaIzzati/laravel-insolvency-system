<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditService;
use App\Imports\UserImport;
use App\Notifications\PasswordResetNotification;
use App\Notifications\PasswordChangeConfirmationNotification;
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
                  ->orWhere('email', 'like', "%{$searchTerm}%")
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
                $searchTerm, 
                'User Management', 
                $users->total(),
                $request
            );
        }
        
        return view('user-management.index', compact('users'));
    }

    public function create()
    {
        return view('user-management.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'login_id' => 'required|string|max:255|unique:users,login_id',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', 'string', 'min:12'],
            'role' => 'required|in:superuser,admin,id_management,staff',
            'branch_code' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'status' => 'required|in:active,inactive,suspended,expired',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'login_id' => $request->login_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'branch_code' => $request->branch_code,
            'is_active' => $request->boolean('is_active', true),
            'status' => $request->status,
            'last_modified_date' => now(),
            'last_modified_user' => auth()->user()->name ?? 'System',
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
        return view('user-management.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'login_id' => 'required|string|max:255|unique:users,login_id,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:superuser,admin,id_management,staff',
            'branch_code' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'status' => 'required|in:active,inactive,suspended,expired',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldValues = $user->getAttributes();

        $user->update([
            'name' => $request->name,
            'login_id' => $request->login_id,
            'email' => $request->email,
            'role' => $request->role,
            'branch_code' => $request->branch_code,
            'is_active' => $request->boolean('is_active', true),
            'status' => $request->status,
            'last_modified_date' => now(),
            'last_modified_user' => auth()->user()->name ?? 'System',
        ]);

        // Log the user update
        AuditService::logUserUpdate(auth()->user(), $user, $oldValues, $request);

        return redirect()->route('user-management.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deletion of superuser accounts
        if ($user->isSuperUser()) {
            return redirect()->back()
                ->with('error', 'Cannot delete superuser accounts.');
        }

        $oldValues = $user->getAttributes();
        
        $user->delete();

        // Log the user deletion
        AuditService::logUserDeletion(auth()->user(), $user, $oldValues, request());

        return redirect()->route('user-management.index')
            ->with('success', 'User deleted successfully.');
    }

    public function changePassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', 'string', 'min:12'],
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

        // Send password change confirmation email
        try {
            $user->notify(new PasswordChangeConfirmationNotification(auth()->user()->name, 'admin_change'));
        } catch (\Exception $e) {
            // Log the error but don't fail the password change
            \Log::error('Failed to send password change confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('user-management.index')
            ->with('success', 'Password updated successfully. A confirmation email has been sent to ' . $user->email . '.');
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
            $import = new UserImport();
            Excel::import($import, $file);
            
            // Count imported users (this is a simplified count)
            $importedCount = User::where('created_at', '>=', now()->subMinutes(5))->count();
            
            // Get validation failures if any
            $failures = $import->failures();
            $failureCount = count($failures);
            
            // Log the bulk upload
            AuditService::logBulkUpload(auth()->user(), 'User', $importedCount, $request);
            
            $message = "Users uploaded successfully! {$importedCount} users processed.";
            if ($failureCount > 0) {
                $message .= " {$failureCount} rows had validation errors and were skipped.";
            }
            
            return redirect()->route('user-management.index')
                ->with('success', $message);
                
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

    /**
     * Send password reset email to user
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendPasswordResetEmail(Request $request, User $user)
    {
        // Check if user has email address
        if (empty($user->email)) {
            return redirect()->back()
                ->with('error', 'Cannot send password reset email. User does not have an email address.');
        }

        // Generate password reset token
        $resetToken = $user->generatePasswordResetToken();

        try {
            // Send password reset notification
            $user->notify(new PasswordResetNotification($resetToken, auth()->user()->name ?? 'System Administrator'));

            // Log the password reset email action (only if user is authenticated)
            if (auth()->check()) {
                AuditService::log(
                    auth()->user(),
                    'PASSWORD_RESET_EMAIL',
                    'Sent password reset email to user',
                    $user,
                    null,
                    null,
                    $request,
                    [
                        'user_email' => $user->email,
                        'reset_by' => auth()->user()->name ?? 'System Administrator'
                    ]
                );
            }

            return redirect()->back()
                ->with('success', 'Password reset email sent successfully to ' . $user->email . '. The user can now reset their password using the link in the email.');

        } catch (\Exception $e) {
            // Log the error (only if user is authenticated)
            if (auth()->check()) {
                AuditService::log(
                    auth()->user(),
                    'PASSWORD_RESET_EMAIL_ERROR',
                    'Failed to send password reset email',
                    $user,
                    null,
                    null,
                    $request,
                    [
                        'error' => $e->getMessage(),
                        'user_email' => $user->email
                    ]
                );
            }

            return redirect()->back()
                ->with('error', 'Failed to send password reset email. Please check your email configuration and try again.');
        }
    }

    /**
     * Generate a temporary password
     *
     * @return string
     */
    private function generateTemporaryPassword()
    {
        // Generate a secure temporary password
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
        $password = '';
        $length = 12;
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }
        
        return $password;
    }
}

// User Export Class
class UserExport implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings
{
    public function collection()
    {
        return User::withTrashed()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Login ID',
            'Role',
            'Branch Code',
            'Is Active',
            'Status',
            'Created At',
            'Updated At',
            'Deleted At',
        ];
    }
}

// User Template Export Class
class UserTemplateExport implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings
{
    public function collection()
    {
        // Return comprehensive sample data for template
        return collect([
            [
                'name' => 'Ahmad Rahman',
                'staff_id' => 'EMP001',
                'password' => 'password123',
                'role' => 'staff',
                'branch_code' => 'KL001',
                'status' => 'active',
                'is_active' => 'true',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'staff_id' => 'EMP002',
                'password' => 'password123',
                'role' => 'admin',
                'branch_code' => 'KL002',
                'status' => 'active',
                'is_active' => 'true',
            ],
            [
                'name' => 'Muhammad Ali',
                'staff_id' => 'EMP003',
                'password' => 'password123',
                'role' => 'id_management',
                'branch_code' => 'KL003',
                'status' => 'active',
                'is_active' => 'true',
            ],
            [
                'name' => 'Fatimah Zahra',
                'staff_id' => 'EMP004',
                'password' => 'password123',
                'role' => 'superuser',
                'branch_code' => 'KL004',
                'status' => 'active',
                'is_active' => 'true',
            ],
            [
                'name' => 'Hassan Abdullah',
                'staff_id' => 'EMP005',
                'password' => 'password123',
                'role' => 'staff',
                'branch_code' => 'KL005',
                'status' => 'inactive',
                'is_active' => 'false',
            ],
            [
                'name' => 'Aminah Binti Omar',
                'staff_id' => 'EMP006',
                'password' => 'password123',
                'role' => 'admin',
                'branch_code' => 'KL006',
                'status' => 'suspended',
                'is_active' => 'false',
            ],
            [
                'name' => 'Ibrahim Ismail',
                'staff_id' => 'EMP007',
                'password' => 'password123',
                'role' => 'staff',
                'branch_code' => 'KL007',
                'status' => 'expired',
                'is_active' => 'false',
            ],
            [
                'name' => 'Nurul Aisyah',
                'staff_id' => 'EMP008',
                'password' => 'password123',
                'role' => 'id_management',
                'branch_code' => 'KL008',
                'status' => 'active',
                'is_active' => 'true',
            ],
            [
                'name' => 'Omar Al-Rashid',
                'staff_id' => 'EMP009',
                'password' => 'password123',
                'role' => 'staff',
                'branch_code' => 'KL009',
                'status' => 'active',
                'is_active' => 'true',
            ],
            [
                'name' => 'Zainab Binti Ahmad',
                'staff_id' => 'EMP010',
                'password' => 'password123',
                'role' => 'admin',
                'branch_code' => 'KL010',
                'status' => 'active',
                'is_active' => 'true',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Staff ID',
            'Password',
            'Role (superuser/admin/id_management/staff)',
            'Branch Code',
            'Status (active/inactive/suspended/expired)',
            'Is Active (true/false)',
        ];
    }
}
