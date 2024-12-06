<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\AuthController;

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

// User authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes for "data" endpoints
Route::middleware(['validate_api_key', 'auth:sanctum'])->group(function () {
    Route::post('/data', [DataController::class, 'store']); // Create new record
    Route::put('/data/{id}', [DataController::class, 'update']); // Update record
    Route::delete('/data/{id}', [DataController::class, 'destroy']); // Delete record
});

// Public routes
Route::middleware(['validate_api_key'])->group(function () {
    Route::get('/data', [DataController::class, 'index']); // Fetch data
    Route::get('/data/{id}', [DataController::class, 'show']); // Fetch specific record
});
