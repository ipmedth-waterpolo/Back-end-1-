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
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Admin Routes with Authentication Middleware
Route::middleware(['auth', 'role:admin,onderhoud'])->prefix('admin')->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User Management Routes
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/{id}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::put('/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });

    // Exercise Management Routes
    Route::prefix('exercises')->group(function () {
        Route::get('/', [AdminController::class, 'exercises'])->name('admin.exercises');
        Route::get('/create', [AdminController::class, 'createExercise'])->name('admin.exercises.create');
        Route::get('/{id}', [AdminController::class, 'showExercise'])->name('admin.exercises.show');
        Route::post('/', [AdminController::class, 'storeExercise'])->name('admin.exercises.store');
        Route::put('/{id}', [AdminController::class, 'updateExercise'])->name('admin.exercises.update');
        Route::delete('/{id}', [AdminController::class, 'deleteExercise'])->name('admin.exercises.delete');
        Route::post('/upload', [AdminController::class, 'uploadExercises'])->name('admin.exercises.upload');

    });

    Route::prefix('trainings')->group(function () {
        // List of trainings
        Route::get('/', [AdminController::class, 'trainings'])->name('admin.trainings');
        // Create a new training
        Route::get('/create', [AdminController::class, 'createTraining'])->name('admin.trainings.create');
        // Show a specific training (details view)
        Route::get('/{id}', [AdminController::class, 'showTraining'])->name('admin.trainings.show');
        // Show edit form for a specific training
        Route::get('/{id}/edit', [AdminController::class, 'showTrainingEdit'])->name('admin.trainings.edit');
        // Store new training
        Route::post('/', [AdminController::class, 'storeTraining'])->name('admin.trainings.store');
        // Update an existing training
        Route::put('/{id}', [AdminController::class, 'updateTraining'])->name('admin.trainings.update');
        // Delete a training
        Route::delete('/{id}', [AdminController::class, 'deleteTraining'])->name('admin.trainings.delete');
    });
    

});
