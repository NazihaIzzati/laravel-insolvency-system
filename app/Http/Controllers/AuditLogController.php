<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        // Filter by user role
        if ($request->filled('role')) {
            $query->forRole($request->role);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->byAction($request->action);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $auditLogs = $query->paginate(20);

        // Get filter options
        $roles = ['superuser', 'admin', 'id_management'];
        $actions = AuditLog::distinct()->pluck('action')->sort()->values();
        $users = \App\Models\User::whereIn('role', $roles)->get(['id', 'name', 'email']);

        return view('audit-logs.index', compact('auditLogs', 'roles', 'actions', 'users'));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load('user');
        return view('audit-logs.show', compact('auditLog'));
    }

    public function export(Request $request)
    {
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->filled('role')) {
            $query->forRole($request->role);
        }
        if ($request->filled('action')) {
            $query->byAction($request->action);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $auditLogs = $query->get();

        // Log the export action
        \App\Services\AuditService::logBulkDownload(auth()->user(), 'AuditLog', $auditLogs->count(), $request);

        return response()->json($auditLogs);
    }
}