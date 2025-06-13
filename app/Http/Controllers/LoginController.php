<?php

namespace App\Http\Controllers;

use App\Models\PendingUser;
use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Petani;
use App\Models\Pembeli;
use App\Models\Mitra;
use App\Models\TokenUser;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|min:6',
        ]);

        $input = $validated['email'];
        $pendingUser = PendingUser::where('email', $input)->first();
        if ($pendingUser) {
            return response()->json(['message' => 'Harap verifikasi email terlebih dahulu'], 403);
        }


        $user = User::where('email', $input)->first();

        if (!$user) {
            $petani = Petani::where('username', $input)->first();
            $pembeli = Pembeli::where('username', $input)->first();
            $mitra = Mitra::where('username', $input)->first();

            $roleRecord = $petani ?? $pembeli ?? $mitra;

            if ($roleRecord) {
                $user = User::find($roleRecord->id_user);
            }
        }
        if (!$user) {
            return response()->json(['message' => 'Email atau username tidak ditemukan'], 401);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Password salah'], 401);
        }


        $key = env("JWT_SECRET");
        $payload = [
            'id' => $user->id_user,
            'iat' => time(),
            'role' => $user->role ?? 'guest', 
            'name' => $user->name,
        ];
        $token = JWT::encode($payload, $key, 'HS256');

        // Simpan token ke DB
        TokenUser::create([
            'user_id' => $user->id_user,
            'token' => $token,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'name' => $user->name,
            'role' => $user->role,
        ], 200);
    }
}
