<?php

use App\Http\Controllers\Job\JobController;
use Illuminate\Support\Facades\Route;


Route::any('/search', [JobController::class, 'search'])->name('api.users.search');
Route::middleware(['check.is.headhunter'])->delete('/delete/{id}', [JobController::class, 'destroy'])->name('api.users.destroy');
Route::middleware(['check.is.headhunter'])->put('/update/{id}', [JobController::class, 'update'])->name('apiusers.update');
Route::middleware(['check.is.headhunter'])->post('/create', [JobController::class, 'store'])->name('api.users.store');
Route::get('/show/{id}', [JobController::class, 'show'])->name('api.users.show');
Route::middleware(['check.is.headhunter'])->post('/status/{status}/{id}', [JobController::class, 'statusUpdate'])->name('api.users.status');
Route::get('/index', [JobController::class, 'index'])->name('api.users.index');