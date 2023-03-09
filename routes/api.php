<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth', [App\Http\Controllers\AuthController::class, 'auth'])->name('auth');
Route::get('/notauth', [App\Http\Controllers\AuthController::class, 'notauth'])->name('notauth');
Route::post('/user', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('vacancy')->group(function () {
        Route::get('/', [App\Http\Controllers\VacancyController::class, 'index'])->name('vacancy.index');
        Route::get('/{id}', [App\Http\Controllers\VacancyController::class, 'show'])->name('vacancy.show');
        Route::post('/', [App\Http\Controllers\VacancyController::class, 'store'])->name('vacancy.store');
        Route::put('/{id}', [App\Http\Controllers\VacancyController::class, 'update'])->name('vacancy.update');
        Route::put('/pause/{id}', [App\Http\Controllers\VacancyController::class, 'pause'])->name('vacancy.pause');
        Route::delete('/{id}', [App\Http\Controllers\VacancyController::class, 'destroy'])->name('vacancy.destroy');
        Route::delete('/', [App\Http\Controllers\VacancyController::class, 'batchDestroy'])->name('vacancy.batch.destroy');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');
        Route::put('/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
        Route::delete('/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
        Route::delete('/', [App\Http\Controllers\UserController::class, 'batchDestroy'])->name('user.batch.destroy');
    });
    
    Route::prefix('application')->group(function () {
        Route::get('/', [App\Http\Controllers\ApplicationController::class, 'index'])->name('application.index');
        Route::get('/{id}', [App\Http\Controllers\ApplicationController::class, 'show'])->name('application.show');
        Route::post('/', [App\Http\Controllers\ApplicationController::class, 'store'])->name('application.store');
        Route::put('/{id}', [App\Http\Controllers\ApplicationController::class, 'update'])->name('application.update');
        Route::delete('/{id}', [App\Http\Controllers\ApplicationController::class, 'destroy'])->name('application.destroy');
    });

    Route::prefix('datacsv')->group(function () {
        Route::get("import", [App\Http\Controllers\DataCsvController::class, "importCsv"])->name('datacsv.import');
        Route::get("/", [App\Http\Controllers\DataCsvController::class, "index"])->name('datacsv.index');
    });
});


