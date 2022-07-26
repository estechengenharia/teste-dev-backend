<?php

namespace App\Services;

use App\Http\Resources\User\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthService {

    use ApiResponse;
    
    /**
     * login service
     *
     * @param array $credentials
     * @throws GeneralException
     * @return \Illuminate\Http\Response
     */
    public function login(array $credentials)
    {
        try{
            if (!Auth::attempt($credentials)) {
                return $this->error('Credentials do not match!', 401);
            }

            return $this->success(
                [
                    'token' => auth()->user()->createToken('Web App')->plainTextToken,
                    'user' => new UserResource(auth()->user())
                ],
                'Successful login!'
            );
        }catch(\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }

    /**
     * Logout service
     *
     * @param Request $request
     * @throws GeneralException
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try{
            $request->user()->currentAccessToken()->delete();

            return $this->success(
                null,
                'Logout efetuado com sucesso!'
            );
        }catch(\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }
}