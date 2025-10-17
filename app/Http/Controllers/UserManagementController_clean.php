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
                'User Management', 
                $searchTerm, 
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
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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
            'role' => $request->role,
            'branch_code' => $request->branch_code,
            'is_active' => $request->boolean('is_active', true),
            'status' => $request->status,
            'last_modified_date' => now(),
            'last_modified_user' => auth()->user()->name ?? 'System',
        ]);

        // Log the user update
        AuditService::logUserUpdate(auth()->user(), $user, $oldValues, $user->fresh()->getAttributes(), $request);

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
        // Return sample data for template
        return collect([
            [
                'name' => 'John Doe',
                'staff_id' => 'EMP001',
                'password' => 'password123',
                'role' => 'staff',
                'branch_code' => 'BR001',
                'status' => 'active',
                'is_active' => 'true',
            ],
            [
                'name' => 'Jane Smith',
                'staff_id' => 'EMP002',
                'password' => 'password123',
                'role' => 'admin',
                'branch_code' => 'BR002',
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
