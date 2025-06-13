<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LahanController extends Controller
{
    public function index()
    {
        $lahan = Lahan::select('latitude', 'longitude')->get();
        return response()->json($lahan);
    }

    public function show($id)
    {
        $lahan = Lahan::with(['user:id_user,name'])
            ->select('id_lahan', 'id_petani', 'lokasi_lahan', 'latitude', 'longitude', 'bentuk_lahan')
            ->findOrFail($id);

        return response()->json([
            'id' => $lahan->id_lahan,
            'lokasi_lahan' => $lahan->lokasi_lahan,
            'latitude' => $lahan->latitude,
            'longitude' => $lahan->longitude,
            'bentuk_lahan' => $lahan->bentuk_lahan,
            'nama_petani' => $lahan->user->name ?? null,
        ]);
    }

    // Admin
    public function create(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'id_petani' => 'required|exists:user,id_user',
            'lokasi_lahan' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'bentuk_lahan' => 'required|json',
            'ukuran_lahan' => 'required|numeric',
            'ph_tanah' => 'required|numeric',
            'ketersediaan_air' => 'required|numeric',
        ]);

        $petani = User::where('id_user', $validated['id_petani'])->where('role', 'petani')->first();
        if (!$petani) {
            return response()->json(['message' => 'id_petani harus user dengan role petani'], 422);
        }

        $lahan = Lahan::create($validated);
        return response()->json(['message' => 'Lahan berhasil ditambahkan', 'data' => $lahan], 201);
    }


    // ADMIN ONLY - Update data
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $lahan = Lahan::findOrFail($id);

        $validated = $request->validate([
            'id_petani' => 'required|exists:user,id_user',
            'lokasi_lahan' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'bentuk_lahan' => 'nullable|json',
            'ukuran_lahan' => 'nullable|numeric',
            'ph_tanah' => 'nullable|numeric',
            'ketersediaan_air' => 'nullable|numeric',
        ]);

        $petani = User::where('id_user', $validated['id_petani'])->where('role', 'petani')->first();
        if (!$petani) {
            return response()->json(['message' => 'id_petani harus user dengan role petani'], 422);
        }

        $lahan->update($validated);
        return response()->json(['message' => 'Lahan berhasil diperbarui', 'data' => $lahan]);
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $lahan = Lahan::findOrFail($id);
        $lahan->delete();
        return response()->json(['message' => 'Lahan berhasil dihapus']);
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Hanya admin yang boleh mengakses');
        }
    }
}
