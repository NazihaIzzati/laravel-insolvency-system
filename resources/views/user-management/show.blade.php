@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">User Details</h1>
                    <p class="text-gray-600 mt-1">View detailed information about {{ $user->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('user-management.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors duration-200" 
                       style="background-color: #dc2626;"
                       onmouseover="this.style.backgroundColor='#b91c1c';"
                       onmouseout="this.style.backgroundColor='#dc2626';">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Users
                    </a>
                </div>
            </div>
        </div>

        <!-- User Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">User Information</h3>
            </div>
            
            <div class="p-6">
                <div class="flex items-start space-x-6">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        <div class="h-20 w-20 rounded-full bg-orange-100 flex items-center justify-center">
                            <span class="text-2xl font-bold text-orange-600">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    
                    <!-- User Details -->
                    <div class="flex-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                                <p class="text-lg text-gray-900">{{ $user->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">User Role</label>
                                @if($user->role === 'superuser')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-crown mr-2"></i>
                                        Super User
                                    </span>
                                @elseif($user->role === 'admin')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-user-shield mr-2"></i>
                                        Administrator
                                    </span>
                                @elseif($user->role === 'id_management')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-id-card mr-2"></i>
                                        ID Management
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-users mr-2"></i>
                                        Staff
                                    </span>
                                @endif
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Account Status</label>
                                @if($user->deleted_at)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-ban mr-2"></i>
                                        Inactive
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Active
                                    </span>
                                @endif
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">User ID</label>
                                <p class="text-sm text-gray-900 font-mono">{{ $user->id }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Last Login</label>
                                <p class="text-sm text-gray-900">
                                    {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('M d, Y \a\t g:i A') : 'Never' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Timeline -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Account Timeline</h3>
            </div>
            
            <div class="p-6">
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-white" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-user-plus text-green-600 text-sm"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Account created</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y \a\t g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        @if($user->updated_at && $user->updated_at != $user->created_at)
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-white" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-edit text-blue-600 text-sm"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Account last updated</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('M d, Y \a\t g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                        
                        @if($user->last_login_at)
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-white" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-orange-100 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-sign-in-alt text-orange-600 text-sm"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Last login</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ \Carbon\Carbon::parse($user->last_login_at)->format('M d, Y \a\t g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                        
                        @if($user->deleted_at)
                        <li>
                            <div class="relative">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-ban text-red-600 text-sm"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Account deactivated</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ \Carbon\Carbon::parse($user->deleted_at)->format('M d, Y \a\t g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">User Actions</h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('user-management.edit', $user) }}" class="flex items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-edit text-orange-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Edit User</h4>
                            <p class="text-xs text-gray-500">Update user information</p>
                        </div>
                    </a>
                    
                    @if($user->deleted_at)
                        <form action="{{ route('user-management.restore', $user->id) }}" method="POST" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200 cursor-pointer" onclick="confirmRestore(event, this)">
                            @csrf
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-undo text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Restore User</h4>
                                <p class="text-xs text-gray-500">Reactivate this account</p>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('user-management.destroy', $user) }}" method="POST" class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200 cursor-pointer" onclick="confirmDeactivation(event, this)">
                            @csrf
                            @method('DELETE')
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-ban text-red-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Deactivate User</h4>
                                <p class="text-xs text-gray-500">Disable this account</p>
                            </div>
                        </form>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function confirmDeactivation(event, form) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Deactivate User',
                text: 'Are you sure you want to deactivate this user? This action can be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, deactivate',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function confirmRestore(event, form) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Restore User',
                text: 'Are you sure you want to restore this user? The user will be able to access the system again.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, restore',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endsection
