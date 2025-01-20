<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TrainingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Hier registreer je API-routes voor je applicatie. Alle routes worden
| geladen door de RouteServiceProvider en vallen onder de "api" middleware-groep.
| Maak iets moois!
*/

// Routes zonder authenticatie (maar wel API-key validatie)
Route::middleware(['validate_api_key'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::prefix('training')->group(function () {
        Route::get('/', [TrainingController::class, 'index']);
        Route::get('/{id}', [TrainingController::class, 'show']);
    });

    Route::prefix('data')->group(function () {
        Route::get('/', [DataController::class, 'index']);
        Route::get('/{id}', [DataController::class, 'show']);
    });
});

// Routes voor trainingsbeheer (Trainer, Onderhoud, Admin)
Route::middleware(['validate_api_key', 'auth:sanctum', 'role:trainer,onderhoud,admin'])->prefix('training')->group(function () {
    Route::post('/', [TrainingController::class, 'store'])->name('trainings.store');
    Route::put('/{id}', [TrainingController::class, 'update']);
    Route::delete('/{id}', [TrainingController::class, 'delete']);
});

// Routes voor ratings (Authenticatie vereist)
Route::middleware(['validate_api_key', 'auth:sanctum'])->post('/training/{id}/rating', [TrainingController::class, 'addRating']);

// Routes voor databeheer (Trainer, Onderhoud, Admin)
Route::middleware(['validate_api_key', 'auth:sanctum', 'role:trainer,onderhoud,admin'])->prefix('data')->group(function () {
    Route::post('/', [DataController::class, 'store']);
    Route::put('/{id}', [DataController::class, 'update']);
});

// Routes voor het verwijderen van data (Onderhoud, Admin)
Route::middleware(['validate_api_key', 'auth:sanctum', 'role:onderhoud,admin'])->delete('/data/{id}', [DataController::class, 'destroy']);

// Admin-specifieke routes
Route::middleware(['validate_api_key', 'auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DataController::class, 'adminDashboard']);
});

// Routes voor gebruikersbeheer (geauthenticeerde gebruiker)
Route::middleware(['validate_api_key', 'auth:sanctum'])->prefix('user')->group(function () {
    Route::get('/', [AuthController::class, 'getUserInfo']);
    Route::put('/', [AuthController::class, 'updateUser']);
    Route::delete('/', [AuthController::class, 'deleteUser']);
});

// Routes voor gebruikersbeheer (Admins en Onderhoud)
Route::middleware(['validate_api_key', 'auth:sanctum', 'role:onderhoud,admin'])->prefix('users')->group(function () {
    Route::get('/{id}', [AuthController::class, 'getAnyUserInfo']);
    Route::put('/{id}', [AuthController::class, 'updateAnyUser']);
    Route::delete('/{id}', [AuthController::class, 'deleteAnyUser']);
    Route::get('/', [AuthController::class, 'getAllUsersInfo']);
});

