<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
