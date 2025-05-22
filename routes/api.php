<?php

use App\Http\Controllers\{AuthController,JobOfferApplicationController,JobOfferController,TemperatureAnalysisController,UserController};
use App\Http\Middleware\IsRecruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::prefix('users')->group(function () {
    Route::get('', [UserController::class, 'index'])->middleware(['auth:sanctum', IsRecruiter::class]);
    Route::post('', [UserController::class, 'store']);
    Route::get('{user}', [UserController::class, 'show']);
    Route::put('{user}', [UserController::class, 'update']);
    Route::delete('', [UserController::class, 'destroy']);
})->middleware('auth:sanctum');

Route::prefix('job-offers')->group(function () {
    Route::get('', [JobOfferController::class, 'index']);
    Route::post('', [JobOfferController::class, 'store'])->middleware(['auth:sanctum', IsRecruiter::class]);;
    Route::get('{jobOffer}', [JobOfferController::class, 'show']);
    Route::put('{jobOffer}', [JobOfferController::class, 'update'])->middleware(['auth:sanctum', IsRecruiter::class]);
    Route::delete('{jobOffer}', [JobOfferController::class, 'destroy'])->middleware(['auth:sanctum', IsRecruiter::class]);
    Route::put('{jobOffer}/toggle-status', [JobOfferController::class, 'toggleStatus'])->middleware(['auth:sanctum', IsRecruiter::class]);
});

Route::prefix('applications')->group(function () {
    Route::get('', [JobOfferApplicationController::class, 'index']);
    Route::post('', [JobOfferApplicationController::class, 'store']);
    Route::get('user/{user}', [JobOfferApplicationController::class, 'getUserApplications']);
    Route::get('job-offers/{jobOffer}/', [JobOfferApplicationController::class, 'getJobOfferApplicants']);
    Route::delete('user/{user}/job-offers/{jobOffer}', [JobOfferApplicationController::class, 'destroy']);
})->middleware(['auth:sanctum', IsRecruiter::class]);

Route::get('/temperature-analysis', [TemperatureAnalysisController::class, 'analyze']);
