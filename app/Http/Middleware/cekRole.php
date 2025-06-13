<?php

namespace App\Http\Middleware;

use App\Models\User; // Pastikan User model di-import
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class cekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $requiredRole  Role yang dibutuhkan untuk mengakses route
     */
    public function handle(Request $request, Closure $next, string $requiredRole): Response
    {
         $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Pengguna belum terautentikasi.'], 401);
        }

        if ($user->role !== $requiredRole) {
            return response()->json([
                'message' => 'Anda tidak memiliki izin (' . $requiredRole . ') untuk mengakses fitur ini.'
            ], 403);
        }

        return $next($request);
    }
}