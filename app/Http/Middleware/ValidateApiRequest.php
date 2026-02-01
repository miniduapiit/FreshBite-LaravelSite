<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiRequest
{
    /**
     * Handle an incoming request.
     * 
     * Validates API requests to ensure:
     * - Content-Type is application/json for POST/PUT requests
     * - Accept header includes application/json
     * - Request size is within limits
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check Accept header for JSON API requests
        if ($request->wantsJson() && !$request->expectsJson()) {
            return response()->json([
                'message' => 'API requests must include Accept: application/json header.'
            ], 406);
        }

        // Validate Content-Type for POST/PUT/PATCH requests
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $contentType = $request->header('Content-Type');
            if (!$request->isJson() && (!$contentType || !str_contains($contentType, 'application/json'))) {
                return response()->json([
                    'message' => 'Content-Type: application/json header is required.'
                ], 415);
            }
        }

        // Check request size (prevent DoS)
        $maxSize = 1024 * 1024; // 1MB
        $contentLength = $request->header('Content-Length');
        if ($contentLength && (int)$contentLength > $maxSize) {
            return response()->json([
                'message' => 'Request payload too large.'
            ], 413);
        }

        return $next($request);
    }
}
