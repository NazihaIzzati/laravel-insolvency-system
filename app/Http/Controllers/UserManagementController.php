<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->orderBy('created_at', 'desc')->paginate(10);
        return view('user-management.index', compact('users'));
    }

    public function create()
    {
        return view('user-management.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:superuser,admin,id_management,staff'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:superuser,admin,id_management,staff'],
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
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Log the user update
        AuditService::logUserUpdate(auth()->user(), $user, $oldValues, $request);

        return redirect()->route('user-management.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Log the user deletion
        AuditService::logUserDeletion(auth()->user(), $user, request());
        
        $user->delete();
        return redirect()->route('user-management.index')
            ->with('success', 'User deactivated successfully.');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        // Log the user restoration
        AuditService::logUserRestoration(auth()->user(), $user, request());
        
        $user->restore();
        return redirect()->route('user-management.index')
            ->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        // Store user data for audit log before deletion
        $userData = $user->getAttributes();
        
        // Log the user permanent deletion
        AuditService::logUserForceDeletion(auth()->user(), $userData, request());
        
        $user->forceDelete();
        return redirect()->route('user-management.index')
            ->with('success', 'User permanently deleted.');
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
        ]);

        // Log the password change
        AuditService::logPasswordChange(auth()->user(), $user, $request);

        return redirect()->route('user-management.index')
            ->with('success', 'Password updated successfully.');
    }

    public function bulkUpload()
    {
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

// User Import Class
class UserImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? 'password123'), // Default password
            'role' => $row['role'] ?? 'user',
            'is_active' => $row['is_active'] ?? true,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:superuser,admin,id_management,staff',
            'is_active' => 'nullable|boolean',
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
                'email' => $user->email,
                'role' => $user->role,
                'is_active' => $user->is_active ? 'Yes' : 'No',
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
            'Email',
            'Role',
            'Is Active',
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
                'john.doe@example.com',
                'password123',
                'staff',
                true,
            ],
            [
                'Jane Smith',
                'jane.smith@example.com',
                'password123',
                'admin',
                true,
            ],
            [
                'Bob Wilson',
                'bob.wilson@example.com',
                'password123',
                'id_management',
                true,
            ],
            [
                'Alice Johnson',
                'alice.johnson@example.com',
                'password123',
                'superuser',
                true,
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Password',
            'Role (superuser/admin/id_management/staff)',
            'Is Active (true/false)',
        ];
    }
}
