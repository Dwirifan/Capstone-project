<?php

namespace App\Http\Controllers;

use App\Models\Beras;
use App\Models\Gabah;
use App\Models\Tebas;
use App\Models\Produk;
use App\Models\FileProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProdukController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'tipe_produk' => 'required|in:beras,gabah,tebas',
            'nama' => 'required|string|max:255',
            'files' => 'nullable|array|max:4',
            'files.*' => 'file|max:5120|mimes:jpg,jpeg,png,mp4',
        ]);

        DB::beginTransaction();
        try {
            $user = auth()->user();

            $produk = Produk::create([
                'id_petani' => $user->id_user,
                'tipe_produk' => $request->tipe_produk,
                'nama' => $request->nama,
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $mime = $file->getMimeType();

                    $tipe_file = str_starts_with($mime, 'image/') ? 'foto' :
                        (str_starts_with($mime, 'video/') ? 'video' : null);

                    if (!$tipe_file) {
                        throw new \Exception("Tipe file tidak didukung: $mime");
                    }

                    $folder = $tipe_file === 'foto' ? 'produk/foto' : 'produk/video';
                    $path = $file->store($folder, 'public');

                    FileProduk::create([
                        'id_produk' => $produk->id_produk,
                        'tipe_file' => $tipe_file,
                        'file_path' => $path,
                    ]);
                }
            }

            // Simpan detail sesuai tipe
            if ($request->tipe_produk === 'beras') {
                Beras::create([
                    'id_produk' => $produk->id_produk,
                    'id_produksi' => $request->id_produksi,
                    'kualitas_beras' => $request->kualitas_beras,
                    'harga_kg' => $request->harga_kg,
                    'stok_kg' => $request->stok_kg,
                    'deskripsi' => $request->deskripsi
                ]);
            } elseif ($request->tipe_produk === 'gabah') {
                Gabah::create([
                    'id_produk' => $produk->id_produk,
                    'id_panen' => $request->id_panen,
                    'kualitas_gabah' => $request->kualitas_gabah,
                    'rendemen_gabah' => $request->rendemen_gabah,
                    'harga_gabah' => $request->harga_gabah,
                    'stok_kg' => $request->stok_kg,
                    'deskripsi' => $request->deskripsi
                ]);
            } elseif ($request->tipe_produk === 'tebas') {
                Tebas::create([
                    'id_produk' => $produk->id_produk,
                    'id_lahan' => $request->id_lahan,
                    'umur_padi' => $request->umur_padi,
                    'rendemen_padi' => $request->rendemen_padi,
                    'harga_m2' => $request->harga,
                    'stock_tebas' => 'available',
                    'deskripsi' => $request->deskripsi
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Produk berhasil ditambahkan'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $produk = Produk::findOrFail($id);
            if ($produk->tipe_produk === 'beras') {
                Beras::where('id_produk', $produk->id_produk)->update([
                    'kualitas_beras' => $request->kualitas_beras,
                    'harga_kg' => $request->harga_kg,
                    'stok_kg' => $request->stok_kg,
                    'deskripsi' => $request->deskripsi
                ]);
            } elseif ($produk->tipe_produk === 'gabah') {
                Gabah::where('id_produk', $produk->id_produk)->update([
                    'kualitas_produk' => $request->kualitas_gabah,
                    'rendemen_gabah' => $request->rendemen_gabah,
                    'harga_kg' => $request->harga_kg,
                    'stok_kg' => $request->stok_kg,
                    'deskripsi' => $request->deskripsi
                ]);
            } elseif ($produk->tipe_produk === 'tebas') {
                Tebas::where('id_produk', $produk->id_produk)->update([
                    'umur_padi' => $request->umur_padi,
                    'rendemen_padi' => $request->rendemen_padi,
                    'harga_m2' => $request->harga_m2,
                    'deskripsi' => $request->deskripsi
                ]);
            }
            DB::commit();
            return response()->json(['message' => 'Produk berhasil diperbarui'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal memperbarui produk: ' . $e->getMessage()], 500);

        }
    }
    public function hapus($id)
    {
        DB::beginTransaction();
        try {
            $produk = Produk::findOrFail($id);

            if ($produk->tipe_produk === 'beras') {
                Beras::where('id_produk', $produk->id_produk)->delete();
            } elseif ($produk->tipe_produk === 'gabah') {
                Gabah::where('id_produk', $produk->id_produk)->delete();
            } elseif ($produk->tipe_produk === 'tebas') {
                Tebas::where('id_produk', $produk->id_produk)->delete();
            }

            $produk->delete();

            DB::commit();
            return response()->json(['message' => 'Produk berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus produk: ' . $e->getMessage()], 500);
        }
    }

public function produkrekomendasi(Request $request)
{
    $user = Auth::user();
    
    $produkQuery = Produk::with([
        'beras',
        'gabah',
        'tebas.lahan',
        'petani',
        'file_produk'
    ]);
    if ($user) {
        $idUser = $user->id_user;
        $aiModelUrl = "http://127.0.0.1:8000/recommendation/{$idUser}";

        $response = Http::get($aiModelUrl);

        if ($response->successful()) {
            $recommendedIds = $response->json()['recommended_produk_ids'] ?? [];

            if (!empty($recommendedIds)) {
                $produkQuery->whereIn('id_produk', $recommendedIds);
            }
        }
    }

    $produk = $produkQuery->get();

    $produkList = $produk->map(function ($item) {
        $fotoFile = $item->file_produk?->firstWhere('tipe_file', 'foto');

        $data = [
            'id' => $item->id_produk,
            'tipe' => $item->tipe_produk,
            'rating' => $item->rating,
            'nama' => $item->nama,
            'foto' => $fotoFile ? asset('storage/' . $fotoFile->file_path) : null,
            'lokasi' => null,
            'harga' => null,
            'detail' => null,
        ];

        if ($item->tipe_produk === 'beras' && $item->beras) {
            $data['harga'] = $item->beras->harga_kg;
            $data['lokasi'] = $item->petani?->alamat;
            $data['detail'] = [
                'kualitas' => $item->beras->kualitas_beras,
                'stok_kg' => $item->beras->stok_kg,
                'deskripsi' => $item->beras->deskripsi,
            ];
        } elseif ($item->tipe_produk === 'gabah' && $item->gabah) {
            $data['harga'] = $item->gabah->harga_gabah;
            $data['lokasi'] = $item->petani?->alamat;
            $data['detail'] = [
                'kualitas' => $item->gabah->kualitas_gabah,
                'stok_kg' => $item->gabah->stok_kg,
                'deskripsi' => $item->gabah->deskripsi,
            ];
        } elseif ($item->tipe_produk === 'tebas' && $item->tebas) {
            $data['harga'] = $item->tebas->harga_m2;
            $data['lokasi'] = $item->tebas->lahan?->lokasi_lahan;
            $data['detail'] = [
                'umur_padi' => $item->tebas->umur_padi,
                'rendeman_padi' => $item->tebas->rendemen_padi,
                'stok_produk' => $item->tebas->stock_tebas,
                'deskripsi' => $item->tebas->deskripsi,
            ];
        }

        return $data;
    });

    return response()->json($produkList);
}


    public function index()
    {
        $produk = Produk::with([
            'beras',
            'gabah',
            'tebas.lahan',
            'petani',
            'file_produk'
        ])->get();

        $produkList = $produk->map(function ($item) {
            // aman dari null
            $fotoFile = $item->file_produk?->firstWhere('tipe_file', 'foto');

            $data = [
                'id' => $item->id_produk,
                'tipe' => $item->tipe_produk,
                'rating' => $item->rating,
                'nama' => $item->nama,
                'foto' => $fotoFile ? asset('storage/' . $fotoFile->file_path) : null,
                'lokasi' => null,
                'harga' => null,
            ];

            if ($item->tipe_produk === 'beras' && $item->beras) {
                $data['harga'] = $item->beras->harga_kg;
                $data['lokasi'] = $item->petani?->alamat;
            } elseif ($item->tipe_produk === 'gabah' && $item->gabah) {
                $data['harga'] = $item->gabah->harga_gabah;
                $data['lokasi'] = $item->petani?->alamat;
            } elseif ($item->tipe_produk === 'tebas' && $item->tebas) {
                $data['harga'] = $item->tebas->harga_m2;
                $data['lokasi'] = $item->tebas->lahan?->lokasi_lahan;
            }

            return $data;
        });

        return response()->json($produkList);
    }


    public function detail($id)
{
    $produk = Produk::with([
        'beras.produksi',
        'gabah.panen',
        'tebas.lahan.cuaca',
        'tebas.lahan.pertanian',
        'detailfile'
    ])->findOrFail($id);

    $data = [
        'id_produk' => $produk->id_produk,
        'tipe_produk' => $produk->tipe_produk,
        'nama' => $produk->nama,
        'rating' => $produk->rating,
        'jumlah_penjualan' => $produk->jumlah_penjualan,
        'files' => $produk->detailfile->map(function ($file) {
            return [
                'tipe_file' => $file->tipe_file,
                'url' => asset('storage/' . $file->file_path),
            ];
        }),
    ];

    if ($produk->tipe_produk === 'beras' && $produk->beras) {
        $data['detail'] = [
            'kualitas' => $produk->beras->kualitas_beras,
            'harga_kg' => $produk->beras->harga_kg,
            'stok_kg' => $produk->beras->stok_kg,
            'deskripsi' => $produk->beras->deskripsi,
            'produksi' => $produk->beras->produksi ? [
                'tgl_pengemasan' => $produk->beras->produksi->tgl_pengemasan,
                'metode_pembersihan' => $produk->beras->produksi->metode_pembersihan,
                'jenis_penggilingan' => $produk->beras->produksi->jenis_penggilingan,
                'kondisi_penyimpanan' => $produk->beras->produksi->kondisi_penyimpanan,
            ] : null,
        ];
    } elseif ($produk->tipe_produk === 'gabah' && $produk->gabah) {
        $data['detail'] = [
            'kualitas' => $produk->gabah->kualitas_gabah,
            'harga_kg' => $produk->gabah->harga_gabah,
            'stok_kg' => $produk->gabah->stok_kg,
            'deskripsi' => $produk->gabah->deskripsi,
            'panen' => $produk->gabah->panen ? [
                'teknik_panen' => $produk->gabah->panen->teknik_panen,
                'jenis_pengeringan' => $produk->gabah->panen->jenis_pengeringan,
                'durasi_pengeringan' => $produk->gabah->panen->durasi_pengeringan,
            ] : null,
        ];
    } elseif ($produk->tipe_produk === 'tebas' && $produk->tebas) {
        $lahan = $produk->tebas->lahan;
        $data['detail'] = [
            'umur_padi' => $produk->tebas->umur_padi,
            'harga' => $produk->tebas->harga,
            'rendeman_padi' => $produk->tebas->rendeman_padi,
            'stok_produk' => $produk->tebas->stok_produk,
            'deskripsi' => $produk->tebas->deskripsi,
            'lahan' => $lahan ? [
                'bentuk_lahan' => $lahan->bentuk_lahan,
                'ukuran_lahan' => $lahan->ukuran_lahan,
                'ph_tanah' => $lahan->ph_tanah,
                'ketersediaan_air' => $lahan->ketersediaan_air,
                'cuaca' => $lahan->cuaca ? [
                    'curah_hujan_harian' => $lahan->cuaca->curah_hujan_harian,
                    'intensitas_cahaya_matahari' => $lahan->cuaca->intensitas_cahaya_matahari,
                ] : null,
                'pertanian' => $lahan->pertanian ? [
                    'metode_tanam' => $lahan->pertanian->metode_tanam,
                    'jenis_pupuk' => $lahan->pertanian->jenis_pupuk,
                    'dosis_pupuk_HA' => $lahan->pertanian->dosis_pupuk_HA,
                    'jumlah_gabah_percabang' => $lahan->pertanian->jumlah_gabah_percabang,
                    'presentase_gabah_isi_hampa' => $lahan->pertanian->presentase_gabah_isi_hampa,
                ] : null,
            ] : null,
        ];
    }

    return response()->json($data);
}

    public function dataproduk()
    {
        $produk = Produk::select('id_produk', 'nama', 'rating', 'jumlah_penjualan')->get();

        return response()->json([
            'message' => 'data produk berhasil dikirim',
            'data' => $produk,
        ], 200);
    }
}
