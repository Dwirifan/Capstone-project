<?php

namespace App\Http\Controllers;

use App\Models\PendingUser;
use App\Models\User;
use App\Models\TokenUser;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class RegisterOauth extends Controller
{
    public function redirectToGoogle()
    {
        config(['services.google.redirect' => env('GOOGLE_REDIRECT_REGISTER')]);
        return Socialite::driver('google')->redirect();
    }

public function handleGoogleCallback(Request $request)
{
    // TAMBAHKAN BARIS INI - INI ADALAH PERBAIKANNYA
    config(['services.google.redirect' => env('GOOGLE_REDIRECT_REGISTER')]);

    try {
        // Baris di bawah ini sekarang akan berhasil
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            Auth::login($user);
            return response()->json([
                'message' => 'Login berhasil',
                'user' => $user,
            ]);
        }

        // Coba buat pending user
        try {
            $pending = PendingUser::firstOrCreate(
                ['email' => $googleUser->getEmail()], // Cari berdasarkan email
                [                                   // Jika tidak ada, buat dengan data ini
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                ]
            );

        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('DATABASE ERROR SAAT MEMBUAT PENDING USER: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menyimpan data ke database.',
                'error' => 'Periksa struktur tabel `pending_user`.',
                'raw_error' => $e->getMessage()
            ], 500);
        }

        // Jika berhasil, redirect ke frontend
        return redirect("https://frontendmu.com/privacy-confirm?pending_id={$pending->id}");

    } catch (\Exception $e) {
        \Log::error('GOOGLE AUTHENTICATION FAILED: ' . $e->getMessage());
        // Anda bisa membuat halaman error yang lebih baik di sini
        return response()->json([
            'message' => 'Autentikasi Google gagal setelah callback.',
            'error' => $e->getMessage(),
        ], 400);
    }
}
    public function confirmPrivacy(Request $request)
    {
        $request->validate([
            'pending_id' => 'required|exists:pending_user,id',
        ]);

        $pendingUser = PendingUser::findOrFail($request->pending_id);

        $user = null;

        DB::transaction(function () use ($pendingUser, &$user) {
            $user = User::create([
                'name' => $pendingUser->name,
                'email' => $pendingUser->email,
                'password' => $pendingUser->password,
                'email_verified_at' => now(),
                'google_id' => $pendingUser->google_id,
            ]);

            $pendingUser->delete();
        });

        Auth::login($user);

        // JWT
        $key = env("JWT_SECRET");
        $payload = [
            'id' => $user->id,
            'iat' => time(),
        ];
        $token = JWT::encode($payload, $key, 'HS256');

        TokenUser::create([
            'user_id' => $user->id,
            'token' => $token,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil dan privacy policy disetujui',
            'token' => $token,
        ]);
    }
}
