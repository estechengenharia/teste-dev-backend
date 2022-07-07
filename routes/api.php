<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});

Route::post('/login', function(Request $request){

if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    $user = Auth::user();
    $token = $user->createToken('JWT');
    return response()->json($token->plainTextToken, 200);
}
return response()->json('Usuario Inválido', 401);
});