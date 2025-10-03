<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HealthController extends BaseApiController
{
    public function check(): JsonResponse
    {
        $checks = [
            'status' => 'healthy',
            'timestamp' => now()->toISOString(),
            'version' => config('app.version', '1.0.0'),
            'environment' => app()->environment(),
            'checks' => []
        ];

        // Database check
        try {
            DB::connection()->getPdo();
            $checks['checks']['database'] = ['status' => 'healthy'];
        } catch (\Exception $e) {
            $checks['checks']['database'] = ['status' => 'unhealthy', 'error' => 'Database connection failed'];
            $checks['status'] = 'unhealthy';
        }

        // Cache check
        try {
            Cache::put('health_check', 'ok', 10);
            $value = Cache::get('health_check');
            $checks['checks']['cache'] = ['status' => $value === 'ok' ? 'healthy' : 'unhealthy'];
        } catch (\Exception $e) {
            $checks['checks']['cache'] = ['status' => 'unhealthy', 'error' => 'Cache system failed'];
        }

        return response()->json($checks, $checks['status'] === 'healthy' ? 200 : 503);
    }
}
