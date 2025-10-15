<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CoordinateController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlaneController;
use App\Http\Controllers\NewsController;

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

// Authentication routes (public)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/token', [AuthController::class, 'createToken']); // Legacy endpoint

Route::middleware('auth:sanctum')->group(function () {
    // User info route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Auth management routes
    Route::post('/auth/revoke-token', [AuthController::class, 'revokeToken']);
    Route::post('/auth/revoke-all-tokens', [AuthController::class, 'revokeAllTokens']);

    // Coordinates API routes
    Route::prefix('coordinates')->group(function () {
        // Get all active coordinates (with pagination and search)
        Route::get('/', [CoordinateController::class, 'index']);

        // Get coordinate by ID
        Route::get('/{id}', [CoordinateController::class, 'show']);

        // Search coordinates by location name
        Route::get('/search/location', [CoordinateController::class, 'searchByLocation']);

        // Get nearby coordinates within radius
        Route::get('/search/nearby', [CoordinateController::class, 'getNearby']);
    });

    // Planes API routes
    Route::prefix('planes')->group(function () {
        // Get all planes
        Route::get('/', [PlaneController::class, 'index']);

        // Get plane by ID
        Route::get('/{id}', [PlaneController::class, 'show']);
    });

    // News API routes
    Route::prefix('news')->group(function () {
        // Get latest 3 news (for home screen)
        Route::get('/', [NewsController::class, 'index']);

        // Get all news (for management)
        Route::get('/all', [NewsController::class, 'all']);

        // Create news
        Route::post('/', [NewsController::class, 'store']);

        // Get specific news
        Route::get('/{id}', [NewsController::class, 'show']);

        // Update news
        Route::put('/{id}', [NewsController::class, 'update']);
        Route::patch('/{id}', [NewsController::class, 'update']);

        // Delete news
        Route::delete('/{id}', [NewsController::class, 'destroy']);
    });
});
