<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->login($request->email, $request->password);

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $user->createToken('api-token')->plainTextToken,
                'user' => $user
            ]
        ]);
    }
}