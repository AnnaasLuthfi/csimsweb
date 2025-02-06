<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Ambil token dari sesi
            $token = $request->session()->get('jwt_token');

            // Jika tidak ada token, redirect ke halaman login
            if (!$token) {
                return redirect('/login')->withErrors(['message' => 'Silakan login terlebih dahulu']);
            }

            // Autentikasi token dan login pengguna
            $user = JWTAuth::toUser($token);
            Auth::login($user);

        } catch (\Exception $e) {
            // Tangani kesalahan jika token tidak valid atau sesi tidak ditemukan
            return redirect('/login')->withErrors(['message' => 'Silakan login terlebih dahulu']);
        }

        return $next($request);
    }
}
