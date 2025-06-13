<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PendingUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if ($user) {
            $status = Password::sendResetLink(['email' => $email]);

            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Link reset password dikirim.'], 200)
                : response()->json(['message' => 'Gagal mengirim link reset password.'], 500);
        }
        $pendingUser = PendingUser::where('email', $email)->first();

        if ($pendingUser) {
            return response()->json(['message' => 'Email belum diverifikasi. Harap cek email Anda dan verifikasi terlebih dahulu.'], 403);
        }
        return response()->json(['message' => 'Email tidak ditemukan dalam sistem.'], 404);
    }
}
