@extends('layouts.app')

@section('title', 'Audit Log Details')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Audit Log Details</h1>
                    <p class="text-gray-600 mt-1">Detailed information about this action</p>
                </div>
                <a href="{{ route('audit-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Audit Logs
                </a>
            </div>
        </div>

        <!-- Action Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Action Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Action</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $auditLog->action_color }}-100 text-{{ $auditLog->action_color }}-800">
                            <i class="{{ $auditLog->action_icon }} mr-2"></i>
                            {{ $auditLog->action_display }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date & Time</label>
                        <p class="text-lg text-gray-900">{{ $auditLog->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                        <p class="text-lg text-gray-900">{{ $auditLog->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">User Information</h3>
            </div>
            <div class="p-6">
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="h-16 w-16 rounded-full bg-orange-100 flex items-center justify-center">
                            <span class="text-xl font-bold text-orange-600">{{ substr($auditLog->user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $auditLog->user->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                <p class="text-lg text-gray-900">{{ $auditLog->user->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                                @if($auditLog->user->role === 'superuser')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-crown mr-2"></i>
                                        Super User
                                    </span>
                                @elseif($auditLog->user->role === 'admin')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-user-shield mr-2"></i>
                                        Administrator
                                    </span>
                                @elseif($auditLog->user->role === 'id_management')
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
                                <label class="block text-sm font-medium text-gray-500 mb-1">User ID</label>
                                <p class="text-sm text-gray-900 font-mono">{{ $auditLog->user->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technical Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Technical Details</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">IP Address</label>
                        <p class="text-sm text-gray-900 font-mono">{{ $auditLog->ip_address ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">HTTP Method</label>
                        <p class="text-sm text-gray-900">{{ $auditLog->method ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">URL</label>
                        <p class="text-sm text-gray-900 break-all">{{ $auditLog->url ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">User Agent</label>
                        <p class="text-sm text-gray-900 break-all">{{ $auditLog->user_agent ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Model Information -->
        @if($auditLog->model_type)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Affected Record</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Model Type</label>
                        <p class="text-sm text-gray-900">{{ class_basename($auditLog->model_type) }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Record ID</label>
                        <p class="text-sm text-gray-900 font-mono">{{ $auditLog->model_id }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Data Changes -->
        @if($auditLog->old_values || $auditLog->new_values)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Data Changes</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @if($auditLog->old_values)
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Previous Values</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <pre class="text-xs text-gray-600 whitespace-pre-wrap">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                    @endif
                    
                    @if($auditLog->new_values)
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">New Values</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <pre class="text-xs text-gray-600 whitespace-pre-wrap">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Metadata -->
        @if($auditLog->metadata)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Additional Information</h3>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <pre class="text-xs text-gray-600 whitespace-pre-wrap">{{ json_encode($auditLog->metadata, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
