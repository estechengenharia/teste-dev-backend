<?php

use App\Http\Controllers\Import\ImportController;
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

Route::prefix('v1')->group(function(){
    Route::namespace('Candidate')->group(function(){
        Route::prefix('candidates')->group(base_path('routes/modules/candidate.php'));
    });
    Route::namespace('Job')->group(function(){
        Route::middleware(['auth:sanctum'])->prefix('jobs')->group(base_path('routes/modules/job.php'));
    });
    Route::namespace('User')->group(function(){
        Route::prefix('users')->group(base_path('routes/modules/user.php'));
    });
    Route::namespace('Auth')->group(function(){
        Route::prefix('auth')->group(base_path('routes/modules/auth.php'));
    });
    Route::namespace('Import')->group(function(){
        Route::get('/analitics', [ImportController::class, 'index']);
    });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
