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
Route::middleware(['validate_api_key'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Publieke routes (gasten of leden)
Route::middleware(['validate_api_key'])->group(function () {
    Route::get('/data', [DataController::class, 'index']);
    Route::get('/data/{id}', [DataController::class, 'show']);
});

// Beschermde routes voor trainers en onderhoud
Route::middleware(['validate_api_key','auth:sanctum', 'role:trainer,onderhoud,admin'])->group(function () {
    Route::post('/data', [DataController::class, 'store']);
    Route::put('/data/{id}', [DataController::class, 'update']);
});

// Alleen onderhoud en admins kunnen verwijderen
Route::middleware(['validate_api_key', 'auth:sanctum', 'role:onderhoud,admin'])->group(function () {
    Route::delete('/data/{id}', [DataController::class, 'destroy']);
});

// Admin-only routes
Route::middleware(['validate_api_key','auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DataController::class, 'adminDashboard']);
});

