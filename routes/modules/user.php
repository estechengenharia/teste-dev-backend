<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::any('/search', [UserController::class, 'search'])->name('api.users.search');
Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('api.users.destroy');
Route::put('/update/{id}', [UserController::class, 'update'])->name('apiusers.update');
Route::post('/create', [UserController::class, 'store'])->name('api.users.store');
Route::get('/show/{id}', [UserController::class, 'show'])->name('api.users.show');
Route::post('/status/{status}/{id}', [UserController::class, 'statusUpdate'])->name('api.users.status');
Route::get('/index', [UserController::class, 'index'])->name('api.users.index');