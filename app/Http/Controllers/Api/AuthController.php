<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create a new API token.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required|string|max:255',
            'abilities' => 'nullable|array',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Define available scopes
        $availableScopes = ['products:read', 'orders:read', 'orders:create'];
        
        // Use requested abilities or default to read-only
        $abilities = $request->abilities ?? ['products:read'];
        
        // Validate requested abilities
        $abilities = array_intersect($abilities, $availableScopes);
        
        if (empty($abilities)) {
            $abilities = ['products:read']; // Default to read-only
        }

        $token = $user->createToken($request->device_name, $abilities);

        return response()->json([
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'abilities' => $abilities,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 201);
    }

    /**
     * Revoke the current token.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function revokeToken(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token revoked successfully.',
        ]);
    }

    /**
     * Revoke all tokens for the authenticated user.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function revokeAllTokens(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'All tokens revoked successfully.',
        ]);
    }

    /**
     * Get the authenticated user.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
            'token_abilities' => $request->user()->currentAccessToken()->abilities ?? [],
        ]);
    }
}
