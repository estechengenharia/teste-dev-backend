<?php

use App\Http\Controllers\Candidate\CandidateController;
use Illuminate\Support\Facades\Route;


Route::post('/attach-job/{id}', [CandidateController::class, 'jobAttach'])->name('api.users.attatch.job');
Route::any('/search', [CandidateController::class, 'search'])->name('api.users.search');
Route::delete('/delete/{id}', [CandidateController::class, 'destroy'])->name('api.users.destroy');
Route::put('/update/{id}', [CandidateController::class, 'update'])->name('apiusers.update');
Route::post('/create', [CandidateController::class, 'store'])->name('api.users.store');
Route::get('/show/{id}', [CandidateController::class, 'show'])->name('api.users.show');
Route::post('/status/{status}/{id}', [CandidateController::class, 'statusUpdate'])->name('api.users.status');
Route::get('/index', [CandidateController::class, 'index'])->name('api.users.index');