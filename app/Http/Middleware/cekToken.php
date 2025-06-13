<?php

namespace App\Http\Middleware;

use App\Models\TokenUser;
use App\Models\User;
use Closure;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class cekToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader) {
            return response(['message' => 'Token tidak ditemukan'], 401);
        }
        $parts = explode(' ', $authHeader);
        $jwt_auth = $parts[1] ?? null;
        if (!$jwt_auth) {
            return response()->json(['message' => 'Token tidak ada'], 401);
        }
        $hash = "HS256";
        $key = env("JWT_SECRET");
        $payload = JWT::decode($jwt_auth, new key($key, $hash));

        $user = User::where('id_user', $payload->id)->first();
        if (!$user) {
            return response(['message' => 'Token tidak valid'], 401);
        }
        auth()->setUser($user);
        

        return $next($request);
    }

}

