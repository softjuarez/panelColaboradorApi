<?php

use App\Http\Controllers\Api\UsersApiController;
use App\Http\Controllers\ZipController;
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

// Legacy Sanctum route (kept for backward compatibility)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Legacy route (kept for backward compatibility)
Route::post('/recibir-zip', [ZipController::class, 'recibir']);

/*
|--------------------------------------------------------------------------
| Authenticated API Routes
|--------------------------------------------------------------------------
|
| These routes require basic HTTP authentication and return JSON responses.
| All routes are prefixed with /api and use the api.auth middleware.
|
*/

Route::middleware(['api.auth'])->group(function () {

    // Users endpoints
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersApiController::class, 'index'])->name('api.users.index');
        Route::get('/me', [UsersApiController::class, 'me'])->name('api.users.me');
        Route::get('/{id}', [UsersApiController::class, 'show'])->name('api.users.show');
    });

    // Health check endpoint
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'API is healthy',
            'timestamp' => now()->toISOString(),
            'version' => '1.0.0'
        ]);
    })->name('api.health');

});