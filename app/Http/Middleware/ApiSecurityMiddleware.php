<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiSecurityMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Log all API requests for security monitoring
        Log::info('API Request', [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'user_id' => auth()->id(),
            'timestamp' => now()->toISOString(),
            'headers' => [
                'x-forwarded-for' => $request->header('X-Forwarded-For'),
                'x-real-ip' => $request->header('X-Real-IP'),
                'authorization' => $request->hasHeader('Authorization') ? 'Bearer ***' : null,
                'content-type' => $request->header('Content-Type'),
            ],
            'query' => $request->query(),
            'path' => $request->path(),
        ]);

        $response = $next($request);

        // Add security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('X-API-Version', 'v1');
        
        // CORS headers if needed
        if ($request->getMethod() === 'OPTIONS') {
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        }

        // Log response status for monitoring
        if ($response->getStatusCode() >= 400) {
            Log::warning('API Error Response', [
                'status_code' => $response->getStatusCode(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'response_size' => strlen($response->getContent()),
            ]);
        }

        return $response;
    }
}