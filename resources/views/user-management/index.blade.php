@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                    <p class="text-gray-600 mt-1">Manage system users, roles, and permissions</p>
                </div>
                <div class="flex items-center space-x-4">
                    @if($users->total() > 0)
                        <a href="{{ route('user-management.download') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Download Excel
                        </a>
                    @endif
                    <a href="{{ auth()->user()->isIdManagement() ? route('id-management.dashboard') : (auth()->user()->isSuperUser() ? route('dashboard') : (auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard'))) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 p-6">
            <form method="GET" action="{{ route('user-management.index') }}" class="space-y-4">
                <div class="flex items-center space-x-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}"
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:border-orange-300 focus:ring-2 focus:ring-orange-100 focus:outline-none transition-all duration-200"
                                   placeholder="Search by name, email, staff ID, or role...">
                        </div>
                    </div>
                    
                    <!-- Search Button -->
                    <div class="flex-shrink-0">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                    </div>
                    
                    <!-- Clear Button -->
                    @if(request('search'))
                    <div class="flex-shrink-0">
                        <a href="{{ route('user-management.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Clear
                        </a>
                    </div>
                    @endif
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Users List</h3>
                    <div class="text-sm text-gray-500">
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
                    </div>
                </div>
            </div>
            
            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full overflow-hidden mr-4">
                                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $user->login_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : ($user->isIdManagement() ? 'bg-blue-100 text-blue-800' : ($user->isSuperUser() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800')) }}">
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
                                           class="text-blue-600 hover:text-blue-900 transition-colors duration-200 px-2 py-1 rounded text-sm font-medium"
                                           title="View user details">
                                            View
                                        </a>
                                        <a href="{{ route('user-management.edit', $user) }}" 
                                           class="text-green-600 hover:text-green-900 transition-colors duration-200 px-2 py-1 rounded text-sm font-medium"
                                           title="Edit user">
                                            Edit
                                        </a>
                                        @if(auth()->user()->isSuperUser())
                                        <a href="{{ route('audit-logs.index') }}" 
                                           class="text-purple-600 hover:text-purple-900 transition-colors duration-200 px-2 py-1 rounded text-sm font-medium"
                                           title="View audit logs">
                                            Audit
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
                @endif
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Users Found</h3>
                    <p class="text-gray-500 mb-6">
                        @if(request('search'))
                            No users match your search criteria.
                        @else
                            No users have been created yet.
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('user-management.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Clear Search
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection