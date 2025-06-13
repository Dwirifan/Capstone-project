<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PendingUser;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\VerifyPendingUser;

class RegisterContoller extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|same:konfirmasi_password',
            'konfirmasi_password' => 'required|min:6',
        ]);

        $alreadyExists = PendingUser::where('email', $validated['email'])->exists() ||
            User::where('email', $validated['email'])->exists();

        if ($alreadyExists) {
            return response()->json(['message' => 'Email sudah terdaftar atau sudah diverifikasi'], 409);
        }

        $Newuser = PendingUser::create([
            'name' => $validated['name'],
            'google_id' => null,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $Newuser->notify(new VerifyPendingUser($Newuser));
        return response()->json([
            'message' => 'Registrasi berhasil, silahkan cek email untuk aktivasi',
            'data' => [
                'name' => $Newuser->name,
                'email' => $Newuser->email,
            ],
        ], 201);

    }
    public function verify(Request $request, $id)
    {
        $pendingUser = PendingUser::find($id);

        if (!$pendingUser || $request->email !== $pendingUser->email) {
            return response()->json(['message' => 'Data tidak valid atau link kadaluarsa'], 404);
        }

        if (User::where('email', $pendingUser->email)->exists()) {
            return response()->json(['message' => 'Email sudah diverifikasi sebelumnya']);
        }

        DB::transaction(function () use ($pendingUser) {
            User::create([
                'name' => $pendingUser->name,
                'email' => $pendingUser->email,
                'password' => $pendingUser->password,
                'email_verified_at' => now(),
                'google_id' => $pendingUser->google_id,
            ]);

            $pendingUser->delete();
        });

        $frontendLoginUrl = config('app.frontend_url') . '/autentikasi/login';

        return redirect($frontendLoginUrl);
    }
}
