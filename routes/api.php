<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TrainingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// User authentication routes (no authentication required)
Route::middleware(['validate_api_key'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/trainings', [TrainingController::class, 'store'])->name('trainings.store');;
Route::get('/training', [TrainingController::class, 'index']);
Route::get('/training/{id}', [TrainingController::class, 'show']);
Route::put('/training{id}', [TrainingController::class, 'update']);
Route::delete('/training/{id}', [TrainingController::class, 'delete']);

Route::post('/training/{id}/rating', [TrainingController::class, 'addRating']);

Route::middleware(['validate_api_key'])->group(function () {
    Route::get('/data', [DataController::class, 'index']);
    Route::get('/data/{id}', [DataController::class, 'show']);
});

// Authenticated routes - Trainer, Onderhoud, Admin
Route::middleware(['validate_api_key', 'auth:sanctum', 'role:trainer,onderhoud,admin'])->group(function () {
    Route::post('/data', [DataController::class, 'store']);
    Route::put('/data/{id}', [DataController::class, 'update']);
});

// Admin and Onderhoud routes to delete data
Route::middleware(['validate_api_key', 'auth:sanctum', 'role:onderhoud,admin'])->group(function () {
    Route::delete('/data/{id}', [DataController::class, 'destroy']);
});

// Admin-only routes
Route::middleware(['validate_api_key','auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DataController::class, 'adminDashboard']);
});

// Routes for user to view and manage their own account
Route::middleware(['validate_api_key', 'auth:sanctum'])->group(function () {
    // View user information (for authenticated users only)
    Route::get('/user', [AuthController::class, 'getUserInfo']);

    // Update own user information (for authenticated users only)
    Route::put('/user', [AuthController::class, 'updateUser']);

    // Delete own user account (for authenticated users only)
    Route::delete('/user', [AuthController::class, 'deleteUser']);
});

// Routes for Admins and Onderhoud to manage any user's account
Route::middleware(['validate_api_key', 'auth:sanctum', 'role:onderhoud,admin'])->group(function () {
    // View any user's account info (Admins and Onderhoud)
    Route::get('/user/{id}', [AuthController::class, 'getAnyUserInfo']);

    // Update any user's account (Admins and Onderhoud)
    Route::put('/user/{id}', [AuthController::class, 'updateAnyUser']);

    // Delete any user's account (Admins and Onderhoud)
    Route::delete('/user/{id}', [AuthController::class, 'deleteAnyUser']);

    // Get all users' information (Admins and Onderhoud)
    Route::get('/users', [AuthController::class, 'getAllUsersInfo']);
});


