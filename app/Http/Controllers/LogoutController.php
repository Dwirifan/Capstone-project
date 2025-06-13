<?php

namespace App\Http\Controllers;

use App\Models\TokenUser;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan'], 400);
        }
        $deleted = TokenUser::where('token', $token)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Logout berhasil']);
        } else {
            return response()->json(['message' => 'Token tidak valid atau sudah logout'], 400);
        }
    }
}
