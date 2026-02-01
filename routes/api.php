<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required, but rate limited)
Route::middleware(['validate.api'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('api.products.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('api.products.show');
});

// Authentication routes (rate limited to prevent brute force)
Route::middleware(['validate.api', 'throttle:5,1'])->group(function () {
    Route::post('/auth/token', [AuthController::class, 'createToken'])->name('api.auth.token');
});

Route::middleware(['auth:sanctum', 'validate.api'])->group(function () {
    Route::get('/auth/user', [AuthController::class, 'user'])->name('api.auth.user');
    Route::delete('/auth/token', [AuthController::class, 'revokeToken'])->name('api.auth.revoke');
    Route::delete('/auth/tokens', [AuthController::class, 'revokeAllTokens'])->name('api.auth.revoke-all');
});

// Protected routes (require authentication and rate limiting)
Route::middleware(['auth:sanctum', 'validate.api'])->group(function () {
    // Orders routes - require 'orders:read' scope for GET, 'orders:create' for POST
    Route::get('/orders', [OrderController::class, 'index'])
        ->middleware('ability:orders:read')
        ->name('api.orders.index');
    
    Route::post('/orders', [OrderController::class, 'store'])
        ->middleware('ability:orders:create')
        ->name('api.orders.store');
    
    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->middleware('ability:orders:read')
        ->name('api.orders.show');
});
