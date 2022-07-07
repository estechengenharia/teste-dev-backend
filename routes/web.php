<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::get('/', function () {
        return view('home');
    });
    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::middleware(['recrutador'])->group(function () {

    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware(['auth', 'recrutador']);
    Route::get('/user/new', [App\Http\Controllers\UserController::class, 'new'])->name('new')->middleware(['auth', 'recrutador']);
    Route::post('/user/add', [App\Http\Controllers\UserController::class, 'add'])->name('add')->middleware(['auth', 'recrutador']);
    Route::get('/user/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('edit')->middleware(['auth', 'recrutador']);
    Route::post('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('update')->middleware(['auth', 'recrutador']);
    Route::delete('/user/delet/{id}', [App\Http\Controllers\UserController::class, 'delet'])->name('delet')->middleware(['auth', 'recrutador']);

    Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->name('usuarios')->middleware(['auth', 'recrutador']);
    Route::get('/usuarios/new', [App\Http\Controllers\UsuariosController::class, 'new'])->name('new')->middleware(['auth', 'recrutador']);
    Route::post('/usuarios/add', [App\Http\Controllers\UsuariosController::class, 'add'])->name('add')->middleware(['auth', 'recrutador']);
    Route::get('/usuarios/{id}/edit', [App\Http\Controllers\UsuariosController::class, 'edit'])->name('edit')->middleware(['auth', 'recrutador']);
    Route::post('/usuarios/update/{id}', [App\Http\Controllers\UsuariosController::class, 'update'])->name('update')->middleware(['auth', 'recrutador']);
    Route::delete('/usuarios/delet/{id}', [App\Http\Controllers\UsuariosController::class, 'delet'])->name('delet')->middleware(['auth', 'recrutador']);

    Route::get('/vagas', [App\Http\Controllers\VagasController::class, 'index'])->name('vagas')->middleware(['auth', 'recrutador']);
    Route::get('/vagas/new', [App\Http\Controllers\VagasController::class, 'new'])->name('new')->middleware(['auth', 'recrutador']);
    Route::post('/vagas/add', [App\Http\Controllers\VagasController::class, 'add'])->name('add')->middleware(['auth', 'recrutador']);
    Route::get('/vagas/{id}/edit', [App\Http\Controllers\VagasController::class, 'edit'])->name('edit')->middleware(['auth', 'recrutador']);
    Route::post('/vagas/update/{id}', [App\Http\Controllers\VagasController::class, 'update'])->name('update')->middleware(['auth', 'recrutador']);
    Route::delete('/vagas/delet/{id}', [App\Http\Controllers\VagasController::class, 'delet'])->name('delet')->middleware(['auth', 'recrutador']);
});

Route::middleware(['candidato'])->group(function () {

    Route::get('/vagas', [App\Http\Controllers\VagasController::class, 'index'])->name('vagas')->middleware(['auth', 'candidato']);
    Route::get('/vagas/new', [App\Http\Controllers\VagasController::class, 'new'])->name('new')->middleware(['auth', 'recrutador', 'candidato']);
    Route::post('/vagas/add', [App\Http\Controllers\VagasController::class, 'add'])->name('add')->middleware(['auth', 'recrutador', 'candidato']);
    Route::get('/vagas/{id}/edit', [App\Http\Controllers\VagasController::class, 'edit'])->name('edit')->middleware(['auth', 'candidato']);
    Route::post('/vagas/update/{id}', [App\Http\Controllers\VagasController::class, 'update'])->name('update')->middleware(['auth',  'candidato']);
    Route::delete('/vagas/delet/{id}', [App\Http\Controllers\VagasController::class, 'delet'])->name('delet')->middleware(['auth', 'candidato']);
});
