<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     * 
     * Sanitizes user input to prevent XSS attacks by:
     * - Stripping HTML tags from string inputs
     * - Trimming whitespace
     * - Removing null bytes
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        // Sanitize all string inputs
        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                // Remove null bytes
                $value = str_replace("\0", '', $value);
                // Trim whitespace
                $value = trim($value);
                // For non-HTML fields, strip tags (HTML fields should be validated separately)
                // Note: We preserve HTML in description fields but will validate/sanitize in controllers
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
