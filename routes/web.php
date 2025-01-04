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

// Admin Routes
Route::middleware(['auth', 'role:admin,onderhoud'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
   
    Route::prefix('admin')->group(function () {
        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store'); // New POST route for user creation
        Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });

    // Exercise Management
    Route::prefix('admin')->group(function () {
        Route::get('/exercises', [AdminController::class, 'exercises'])->name('admin.exercises');
        Route::get('/exercises/{id}', [AdminController::class, 'showExercise'])->name('admin.exercises.show');
        Route::get('/exercises/create', [AdminController::class, 'createExercisePage'])->name('admin.exercises.create');
        Route::post('/exercises', [AdminController::class, 'createExercise'])->name('admin.exercises.store');
        Route::put('/exercises/{id}', [AdminController::class, 'updateExercise'])->name('admin.exercises.update');
        Route::delete('/exercises/{id}', [AdminController::class, 'deleteExercise'])->name('admin.exercises.delete');
    });

    // Training Management
    Route::get('/admin/trainings', [AdminController::class, 'trainings'])->name('admin.trainings');
    Route::get('/admin/trainings/{id}', [AdminController::class, 'showTraining'])->name('admin.trainings.show');
    Route::post('/admin/trainings', [AdminController::class, 'createTraining']);
    Route::put('/admin/trainings/{id}', [AdminController::class, 'updateTraining']);
    Route::delete('/admin/trainings/{id}', [AdminController::class, 'deleteTraining']);
});