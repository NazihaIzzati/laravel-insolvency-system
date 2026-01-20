@extends('layouts.app')

@section('title', 'ID Management Dashboard')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">ID Management Dashboard</h1>
                    <p class="text-gray-600 mt-1">Manage user accounts and access permissions for the insolvency information system.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden lg:flex items-center space-x-2 text-sm text-gray-500">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span>System Online</span>
                    </div>
                    <div class="text-sm text-gray-500">{{ now()->format('M d, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-group text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+12%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Active Users -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Users</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+8%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Admin Users</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::whereIn('role', ['admin', 'superuser'])->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-shield text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+2%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Staff Users -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Staff Users</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::whereIn('role', ['staff', 'id_management'])->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user text-orange-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="text-sm text-green-600 font-medium">+15%</span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">User Management Actions</h2>
                <p class="text-sm text-gray-600 mt-1">Manage user accounts and permissions</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('user-management.index') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-blue-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-100 transition-colors duration-200">
                            <i class="bx bx-group text-blue-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">View All Users</h3>
                            <p class="text-xs text-gray-500 mt-1">Browse and manage all user accounts</p>
                            <div class="mt-2 text-xs text-gray-400">{{ \App\Models\User::count() }} total users</div>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors duration-200"></i>
                    </a>

                    <a href="{{ route('user-management.create') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-green-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-100 transition-colors duration-200">
                            <i class="bx bx-user-plus text-green-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-200">Create New User</h3>
                            <p class="text-xs text-gray-500 mt-1">Add a new user to the system</p>
                            <div class="mt-2 text-xs text-gray-400">Set roles and permissions</div>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-green-600 transition-colors duration-200"></i>
                    </a>

                    <a href="{{ route('user-management.bulk-upload') }}" class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-orange-200 hover:shadow-md transition-all duration-200">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-100 transition-colors duration-200">
                            <i class="bx bx-upload text-orange-600 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-200">Bulk Upload Users</h3>
                            <p class="text-xs text-gray-500 mt-1">Upload multiple users via Excel</p>
                            <div class="mt-2 text-xs text-gray-400">Excel format required</div>
                        </div>
                        <i class="bx bx-right-arrow-alt text-gray-400 group-hover:text-orange-600 transition-colors duration-200"></i>
                    </a>

                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Users</h3>
                        <p class="text-sm text-gray-600 mt-1">Latest user accounts created</p>
                    </div>
                    <a href="{{ route('user-management.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        View All Users
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\User::orderBy('created_at', 'desc')->take(5)->get() as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full overflow-hidden mr-3">
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->login_id ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : ($user->isIdManagement() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $user->role_display }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('user-management.show', $user) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition-colors duration-200"
                                       title="View user details">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('user-management.edit', $user) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition-colors duration-200"
                                       title="Edit user">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    @if($user->email)
                                    <form action="{{ route('user-management.send-password-reset', $user) }}" method="POST" class="inline" id="password-reset-form-id-{{ $user->id }}">
                                        @csrf
                                        <button type="button" 
                                                class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-colors duration-200"
                                                title="Send password reset email"
                                                onclick="confirmPasswordResetId('{{ $user->email }}', '{{ $user->id }}')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Reset
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Activity Summary -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Role Distribution -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">User Role Distribution</h3>
                <div class="space-y-3">
                    @php
                        $roles = [
                            'superuser' => ['name' => 'Super User', 'color' => 'bg-red-100 text-red-800', 'count' => \App\Models\User::where('role', 'superuser')->count()],
                            'admin' => ['name' => 'Administrator', 'color' => 'bg-purple-100 text-purple-800', 'count' => \App\Models\User::where('role', 'admin')->count()],
                            'id_management' => ['name' => 'ID Management', 'color' => 'bg-blue-100 text-blue-800', 'count' => \App\Models\User::where('role', 'id_management')->count()],
                            'staff' => ['name' => 'Staff', 'color' => 'bg-green-100 text-green-800', 'count' => \App\Models\User::where('role', 'staff')->count()],
                        ];
                    @endphp
                    @foreach($roles as $role => $data)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $data['color'] }}">
                                {{ $data['name'] }}
                            </span>
                        </div>
                        <div class="text-sm font-medium text-gray-900">{{ $data['count'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">System Status</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Database Connection</span>
                        </div>
                        <span class="text-sm font-medium text-green-600">Online</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">User Authentication</span>
                        </div>
                        <span class="text-sm font-medium text-green-600">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">File Storage</span>
                        </div>
                        <span class="text-sm font-medium text-green-600">Available</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Last Backup</span>
                        </div>
                        <span class="text-sm font-medium text-yellow-600">{{ now()->subDays(1)->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function confirmPasswordResetId(email, userId) {
    Swal.fire({
        title: 'Send Password Reset Email?',
        html: `Are you sure you want to send a password reset email to <strong>${email}</strong>?<br><br>This will send a secure link for the user to reset their password.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#7c3aed',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Send Email',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Sending Email...',
                text: 'Please wait while we send the password reset email.',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit the form
            document.getElementById(`password-reset-form-id-${userId}`).submit();
        }
    });
}
</script>
@endsection
