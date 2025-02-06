<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Session;

class AuthJWT
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!session()->has('jwt_token')) {
                return redirect()->route('login')->withErrors(['message' => 'Silakan login terlebih dahulu.']);
            }

            $token = session('jwt_token');
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                return redirect()->route('login')->withErrors(['message' => 'Token tidak valid, silakan login lagi.']);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['message' => 'Autentikasi gagal.']);
        }

        return $next($request);
    }
}
