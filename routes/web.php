<?php

use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\ophalenOefeningen;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ophalenOefeningen::class, 'index']);
Route::get('/training', [TrainingController::class, 'index']);
Route::get('/training/{id}', [TrainingController::class, 'show'])->name('trainings.show');



