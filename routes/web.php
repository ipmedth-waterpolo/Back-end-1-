<?php

use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ophalenOefeningen;
use Illuminate\Support\Facades\Route;

// Public route to fetch exercises
Route::get('/', [ophalenOefeningen::class, 'index']);

// Authentication Routes
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard - Protected route for Admin/Onderhouder roles
Route::middleware(['auth', 'role:admin,onderhoud'])->group(function () {
    
    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Option selection page
    Route::get('/admin/choose', [AdminController::class, 'chooseOption'])->name('admin.choose');

    // User Management Routes
    Route::prefix('admin/users')->group(function () {
        Route::get('/', [AuthController::class, 'getAllUsersInfo'])->name('admin.users');
        Route::get('{id}', [AuthController::class, 'getAnyUserInfo'])->name('admin.users.show');
        Route::post('/', [AuthController::class, 'register']); // Add new user
        Route::put('{id}', [AuthController::class, 'updateAnyUser']);
        Route::delete('{id}', [AuthController::class, 'deleteAnyUser']);
    });

    // Exercise Management Routes
    Route::prefix('admin/exercises')->group(function () {
        Route::get('/', [DataController::class, 'index'])->name('admin.exercises');
        Route::get('{id}', [DataController::class, 'show'])->name('admin.exercises.show');
        Route::post('/', [DataController::class, 'store']); // Add new exercise
        Route::put('{id}', [DataController::class, 'update']);
        Route::delete('{id}', [DataController::class, 'destroy']);
    });

    // Training Management Routes
    Route::prefix('admin/trainings')->group(function () {
        Route::get('/', [TrainingController::class, 'index'])->name('admin.trainings');
        Route::get('{id}', [TrainingController::class, 'show'])->name('admin.trainings.show');
        Route::post('/', [TrainingController::class, 'store']); // Add new training
        Route::put('{id}', [TrainingController::class, 'update']);
        Route::delete('{id}', [TrainingController::class, 'delete']);
    });
});

// Data Fetching Routes (Public)
Route::get('/data', [DataController::class, 'index']);
Route::get('/data/{id}', [DataController::class, 'show']);

// Training Fetching Routes (Public)
Route::get('/training', [TrainingController::class, 'index']);
Route::get('/training/{id}', [TrainingController::class, 'show'])->name('trainings.show');

// Data Routes for Admins and Onderhoud roles
Route::middleware(['auth', 'role:admin,onderhoud'])->group(function () {
    Route::post('/data', [DataController::class, 'store']);
    Route::put('/data/{id}', [DataController::class, 'update']);
    Route::delete('/data/{id}', [DataController::class, 'destroy']);
});
