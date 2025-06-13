<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use App\Models\TokenUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


class LoginOauth extends Controller
{
    public function redirectToGoogle()
    {
        config(['services.google.redirect' => env('GOOGLE_REDIRECT_LOGIN')]);
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            return redirect()->away(env('FRONTEND_URL') . '/register-with-google?' . http_build_query([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt( Str::random(16)),
            ]));
        }

        //JWT
        $key = env('JWT_SECRET');
        $payload = [
            'id' => $user->id,
            'iat' => time(),
        ];
        $token = JWT::encode($payload, $key, 'HS256');

        TokenUser::create([
            'user_id' => $user->id_user,
            'token' => $token,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user,
        ]);
    }

}
