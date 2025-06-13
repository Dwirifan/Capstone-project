<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Petani;
use App\Models\Pembeli;
use App\Models\Mitra;

class UpdateProfil extends Controller
{
    public function updateProfile(Request $request)
{
     $userId = auth()->user()->id_user;

    $validated = $request->validate([
        'role' => 'required|in:petani,pembeli,mitra',
        'username' => 'required|string|max:255|unique:petani,username,NULL,id_user|unique:pembeli,username,NULL,id_user|unique:mitra,username,NULL,id_user',
        'tgl_lahir' => 'nullable|date',
        'no_hp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'nomor_rekening' => 'nullable|integer',
    ]);

    $user = User::find($userId);
    if (!$user) {
        return response()->json(['message' => 'User tidak ditemukan'], 404);
    }

    $user->role = $validated['role'];
    $user->save();

      $pathFoto = null;
    if ($request->hasFile('foto')) {
        $pathFoto = $request->file('foto')->store('profil', 'public');
    }
    switch ($validated['role']) {
        case 'petani':
            $detail = Petani::updateOrCreate(
                ['id_petani' => $userId],
                [
                    'username' => $validated['username'],
                    'foto' => $pathFoto,
                    'tgl_lahir' => $validated['tgl_lahir'],
                    'no_hp' => $validated['no_hp'],
                    'alamat' => $validated['alamat'],
                    'nomor_rekening' => $validated['nomor_rekening'] ?? null,
                ]
            );
            break;
        case 'pembeli':
            $detail = Pembeli::updateOrCreate(
                ['id_user' => $userId],
                [
                    'username' => $validated['username'],
                    'foto' => $pathFoto,
                    'tgl_lahir' => $validated['tgl_lahir'],
                    'no_hp' => $validated['no_hp'],
                    'alamat' => $validated['alamat'],
                ]
            );
            break;
        case 'mitra':
            $detail = Mitra::updateOrCreate(
                ['id_mitra' => $userId],
                [
                    'username' => $validated['username'],
                    'foto' => $pathFoto,
                    'tgl_lahir' => $validated['tgl_lahir'],
                    'no_hp' => $validated['no_hp'],
                    'alamat' => $validated['alamat'],
                    'nomor_rekening' => $validated['nomor_rekening'] ?? null,
                ]
            );
            break;
    }

    return response()->json([
        'message' => 'Profile berhasil diperbarui',
        'data' => $detail,
    ],201);
}

}
