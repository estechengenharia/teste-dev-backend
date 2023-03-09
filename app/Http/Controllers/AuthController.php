<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function auth(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 400);
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    
                $user = User::where(['email' => $request->email])->first();
                
                $token = $user->createToken('access-token')->plainTextToken;
     
                return response()->json([
                    'success'=>true,
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'user_type'=>$user->user_type,
                    'token'=>$token
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => "Credenciais inválidas."
                ],401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => "Ocorreu uma falha ao tentar autenticar o usuário. <br> Por favor, verifique a documentação ou entre em contato com o suporte."
                //'message' => $th->getMessage()
            ],400);
        }  
    }

    public function notauth(){
        return response()->json([
            'error' => true,
            'message' => "Bearer Token de autenticação não informado ou inválido!"
        ],401);
    }
}
