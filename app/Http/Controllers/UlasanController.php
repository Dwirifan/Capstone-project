<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Transaksi;
use App\Models\UlasanMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UlasanController extends Controller
{

    public function store(Request $request, $id_produk)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'id_transaksi' => 'required|exists:transaksi,id_transaksi',

            'foto' => 'nullable|array|max:2',
            'foto.*' => 'image|mimes:jpeg,png,jpg|max:2048', 
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-matroska|max:10240',
        ]);

       try {
            DB::beginTransaction();

            $userId = $request->user()->id_user;
            // transaksi
            $transaksiSah = Transaksi::where('id_transaksi', $request->id_transaksi)
                ->where('id_user', $userId)->where('id_produk', $id_produk)
                ->where('status_transaksi', 'lunas')->first();

            if (!$transaksiSah) {
                return response()->json(['message' => 'Anda tidak berhak mengulas produk ini.'], 403);
            }

            // cek ulasan
            $existingReview = Ulasan::where('id_user', $userId)->where('id_produk', $id_produk)->first();
            if ($existingReview) {
                return response()->json(['message' => 'Anda sudah mengulas produk ini.'], 400);
            }

            $ulasan = Ulasan::create([
                'id_user' => $userId,
                'id_produk' => $id_produk,
                'id_transaksi' => $request->id_transaksi,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            // ulasan foto 
            if ($request->hasFile('foto')) {
                foreach ($request->file('foto') as $file) {
                    $path = $file->store('ulasan/foto', 'public');
                    UlasanMedia::create([
                        'id_ulasan' => $ulasan->id_ulasan,
                        'file_path' => $path,
                        'tipe_media' => 'foto',
                    ]);
                }
            }

            // ulasan_video
            if ($request->hasFile('video')) {
                $path = $request->file('video')->store('ulasan/video', 'public');
                UlasanMedia::create([
                    'id_ulasan' => $ulasan->id_ulasan,
                    'file_path' => $path,
                    'tipe_media' => 'video',
                ]);
            }
            $this->updateProductRating($id_produk);

            DB::commit(); 
            $ulasan->load('media');

            return response()->json(['message' => 'Ulasan berhasil ditambahkan.', 'data' => $ulasan], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan ulasan.', 'error' => $e->getMessage()], 500);
        }
    }

public function show($id_produk)
{
     $ulasan = Ulasan::with(['user', 'media'])
            ->where('id_produk', $id_produk)
            ->orderByDesc('created_at')
            ->get();

        $averageRating = round($ulasan->avg('rating'), 2);

        return response()->json([
            'id_produk' => (int) $id_produk,
            'rata_rata_rating' => $averageRating,
            'jumlah_ulasan' => $ulasan->count(),
            'ulasan' => $ulasan->map(function ($u) {
                return [
                    'id_ulasan' => $u->id_ulasan,
                    'user' => [ 'name' => $u->user->name ?? 'Pengguna Anonim' ],
                    'rating' => $u->rating,
                    'comment' => $u->comment,
                    // media
                    'media' => $u->media->map(function ($m) {
                        return [
                            'tipe' => $m->tipe_media,
                            'url' => $m->file_path_url,
                        ];
                    }),
                    'waktu' => $u->created_at->diffForHumans(),
                ];
            }),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $ulasan = Ulasan::findOrFail($id);

        if ($ulasan->id_user !== $request->user()->id_user) {
            return response()->json(['message' => 'Tidak diizinkan.'], 403);
        }

        if ($ulasan->is_edited) {
            return response()->json(['message' => 'Ulasan hanya dapat diedit satu kali.'], 400);
        }

        $ulasan->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_edited' => true,
        ]);

        $this->updateProductRating($ulasan->id_produk);

        return response()->json(['message' => 'Ulasan berhasil diperbarui.', 'data' => $ulasan]);
    }

    private function updateProductRating($id_produk)
    {
         $average = Ulasan::where('id_produk', $id_produk)->avg('rating');
        Produk::where('id_produk', $id_produk)->update(['rating_produk' => round($average, 2)]);
    }
}
