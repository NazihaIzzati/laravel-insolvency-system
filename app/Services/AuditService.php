<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class AuditService
{
    /**
     * Log an action performed by a user.
     */
    public static function log(
        User $user,
        string $action,
        string $description,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null,
        ?array $metadata = null
    ): AuditLog {
        // Only log for superuser, admin, and id_management roles
        if (!in_array($user->role, ['superuser', 'admin', 'id_management'])) {
            return new AuditLog(); // Return empty model if role doesn't require logging
        }

        $auditData = [
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'metadata' => $metadata,
        ];

        if ($model) {
            $auditData['model_type'] = get_class($model);
            $auditData['model_id'] = $model->id;
        }

        if ($request) {
            $auditData['ip_address'] = $request->ip();
            $auditData['user_agent'] = $request->userAgent();
            $auditData['url'] = $request->fullUrl();
            $auditData['method'] = $request->method();
        }

        return AuditLog::create($auditData);
    }

    /**
     * Log user creation.
     */
    public static function logUserCreation(User $user, User $createdUser, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'CREATE',
            "Created user: {$createdUser->name} (Staff ID: {$createdUser->login_id})",
            $createdUser,
            null,
            [
                'name' => $createdUser->name,
                'login_id' => $createdUser->login_id,
                'role' => $createdUser->role,
                'branch_code' => $createdUser->branch_code,
                'status' => $createdUser->status,
                'is_active' => $createdUser->is_active,
                'expiry_date' => $createdUser->expiry_date,
            ],
            $request
        );
    }

    /**
     * Log user update.
     */
    public static function logUserUpdate(User $user, User $updatedUser, array $oldValues, ?Request $request = null): AuditLog
    {
        $changes = [];
        foreach ($oldValues as $key => $oldValue) {
            if (isset($updatedUser->getAttributes()[$key]) && $updatedUser->getAttributes()[$key] != $oldValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $updatedUser->getAttributes()[$key]
                ];
            }
        }

        return self::log(
            $user,
            'UPDATE',
            "Updated user: {$updatedUser->name} (Staff ID: {$updatedUser->login_id})",
            $updatedUser,
            $oldValues,
            $updatedUser->getAttributes(),
            $request,
            ['changes' => $changes]
        );
    }

    /**
     * Log user deletion.
     */
    public static function logUserDeletion(User $user, User $deletedUser, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'DELETE',
            "Deactivated user: {$deletedUser->name} ({$deletedUser->email})",
            $deletedUser,
            $deletedUser->getAttributes(),
            null,
            $request
        );
    }

    /**
     * Log user restoration.
     */
    public static function logUserRestoration(User $user, User $restoredUser, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'RESTORE',
            "Restored user: {$restoredUser->name} ({$restoredUser->email})",
            $restoredUser,
            null,
            $restoredUser->getAttributes(),
            $request
        );
    }

    /**
     * Log user permanent deletion.
     */
    public static function logUserForceDeletion(User $user, array $deletedUserData, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'FORCE_DELETE',
            "Permanently deleted user: {$deletedUserData['name']} ({$deletedUserData['email']})",
            null,
            $deletedUserData,
            null,
            $request
        );
    }

    /**
     * Log password change.
     */
    public static function logPasswordChange(User $user, User $targetUser, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'PASSWORD_CHANGE',
            "Changed password for user: {$targetUser->name} (Staff ID: {$targetUser->login_id})",
            $targetUser,
            null,
            null,
            $request
        );
    }

    /**
     * Log bulk upload.
     */
    public static function logBulkUpload(User $user, string $modelType, int $count, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'BULK_UPLOAD',
            "Bulk uploaded {$count} {$modelType} records",
            null,
            null,
            null,
            $request,
            ['model_type' => $modelType, 'count' => $count]
        );
    }

    /**
     * Log bulk download.
     */
    public static function logBulkDownload(User $user, string $modelType, int $count, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'BULK_DOWNLOAD',
            "Bulk downloaded {$count} {$modelType} records",
            null,
            null,
            null,
            $request,
            ['model_type' => $modelType, 'count' => $count]
        );
    }

    /**
     * Log file download.
     */
    public static function logDownload(User $user, string $fileType, string $fileName, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'DOWNLOAD',
            "Downloaded {$fileType}: {$fileName}",
            null,
            null,
            null,
            $request,
            ['file_type' => $fileType, 'file_name' => $fileName]
        );
    }

    /**
     * Log search action.
     */
    public static function logSearch(User $user, string $searchTerm, string $modelType, int $resultsCount, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'SEARCH',
            "Searched for '{$searchTerm}' in {$modelType} - Found {$resultsCount} results",
            null,
            null,
            null,
            $request,
            ['search_term' => $searchTerm, 'model_type' => $modelType, 'results_count' => $resultsCount]
        );
    }

    /**
     * Log login.
     */
    public static function logLogin(User $user, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'LOGIN',
            "Logged in to the system",
            $user,
            null,
            null,
            $request
        );
    }

    /**
     * Log logout.
     */
    public static function logLogout(User $user, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'LOGOUT',
            "Logged out of the system",
            $user,
            null,
            null,
            $request
        );
    }

    /**
     * Log view action.
     */
    public static function logView(User $user, Model $model, ?Request $request = null): AuditLog
    {
        return self::log(
            $user,
            'VIEW',
            "Viewed " . class_basename($model) . ": " . ($model->name ?? $model->id),
            $model,
            null,
            null,
            $request
        );
    }
}
