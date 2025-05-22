<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsRecruiter
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->recruiter) {
            return response()->json([
                'success' => false,
                'message' => 'Acesso não autorizado. Somente recrutadores podem acessar este recurso.'
            ], 403);
        }

        return $next($request);
    }
}