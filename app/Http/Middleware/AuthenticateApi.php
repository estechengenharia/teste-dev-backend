<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AuthenticateApi extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Não autenticado. Token de acesso ausente ou inválido.'
            ], 401);
        }
    }
}