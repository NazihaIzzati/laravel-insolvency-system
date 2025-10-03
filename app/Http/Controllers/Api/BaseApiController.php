<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseApiController extends Controller
{
    protected function successResponse($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ];

        if ($data !== null) {
            if ($data instanceof LengthAwarePaginator) {
                $response['data'] = $data->items();
                $response['meta'] = array_merge($response['meta'], [
                    'current_page' => $data->currentPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                    'last_page' => $data->lastPage(),
                    'from' => $data->firstItem(),
                    'to' => $data->lastItem()
                ]);
                $response['links'] = [
                    'first' => $data->url(1),
                    'last' => $data->url($data->lastPage()),
                    'prev' => $data->previousPageUrl(),
                    'next' => $data->nextPageUrl()
                ];
            } else {
                $response['data'] = $data;
            }
        }

        return response()->json($response, $code);
    }

    protected function errorResponse(string $message = 'Error', $errors = null, int $code = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'error' => [
                'code' => $this->getErrorCode($code),
                'message' => $message
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ];

        if ($errors !== null) {
            $response['error']['details'] = $errors;
        }

        return response()->json($response, $code);
    }

    private function getErrorCode(int $httpCode): string
    {
        return match($httpCode) {
            400 => 'BAD_REQUEST',
            401 => 'UNAUTHORIZED',
            403 => 'FORBIDDEN',
            404 => 'NOT_FOUND',
            422 => 'VALIDATION_ERROR',
            429 => 'RATE_LIMITED',
            500 => 'INTERNAL_SERVER_ERROR',
            default => 'UNKNOWN_ERROR'
        };
    }

    protected function validatePagination(Request $request): array
    {
        return $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100'
        ]);
    }
}
