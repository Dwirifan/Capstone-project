<?php

namespace App\Http\Controllers;

use App\Models\Dp;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Transfer;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Services\ProdukService;
use App\Services\KeuanganService;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['transfer', 'dp'])->get();
        return response()->json($transaksi);
    }



public function store(Request $request)
{
    $validated = $request->validate([
        'id_produk' => 'required|exists:produk,id_produk',
        'metode_transaksi' => 'required|in:DP,transfer',
        'jumlah_barang' => 'required|integer|min:1',
        'status_transaksi' => 'required|in:lunas,belum_lunas',

        // Validasi metode pembayaran
        'bank_pengirim' => 'required_if:metode_transaksi,transfer,DP|string',
        'nama_pengirim' => 'required_if:metode_transaksi,transfer,DP|string',
        'no_rekening_pengirim' => 'required_if:metode_transaksi,transfer,DP|string',
        'bukti_transfer' => 'required_if:metode_transaksi,transfer|string',
        'tgl_transfer' => 'nullable|date',
        'jumlah_dp' => 'required_if:metode_transaksi,DP|numeric',
        'bukti_dp' => 'required_if:metode_transaksi,DP|string',
        'tgl_dp' => 'nullable|date',
    ]);

    return DB::transaction(function () use ($request, $validated) {
        $produk = Produk::with(['beras', 'gabah', 'tebas'])
            ->where('id_produk', $request->id_produk)
            ->lockForUpdate()
            ->first();

        // Cek dan ambil harga item berdasarkan tipe produk
        $hargaItem = 0;
        switch ($produk->tipe_produk) {
            case 'beras':
                if (!$produk->beras) {
                    return response()->json(['message' => 'Data beras tidak ditemukan untuk produk ini'], 422);
                }
                $hargaItem = $produk->beras->harga_kg;
                break;
            case 'gabah':
                if (!$produk->gabah) {
                    return response()->json(['message' => 'Data gabah tidak ditemukan untuk produk ini'], 422);
                }
                $hargaItem = $produk->gabah->harga_gabah;
                break;
            case 'tebas':
                if (!$produk->tebas) {
                    return response()->json(['message' => 'Data tebas tidak ditemukan untuk produk ini'], 422);
                }
                $hargaItem = $produk->tebas->harga_total;
                break;
            default:
                return response()->json(['message' => 'Tipe produk tidak valid'], 422);
        }

        if ($hargaItem <= 0) {
            return response()->json(['message' => 'Harga produk tidak valid atau belum diisi'], 422);
        }

        try {
    ProdukService::cekDanKurangiStok($produk, $request->jumlah_barang);
} catch (\Illuminate\Validation\ValidationException $e) {
    return response()->json([
        'message' => 'Validasi gagal',
        'errors' => $e->errors(),
    ], 422);
}


        $totalTransaksi = $hargaItem * $request->jumlah_barang;

        $transaksiData = array_merge($validated, [
            'id_user' => auth()->id(),
            'harga_item' => $hargaItem,
            'total_transaksi' => $totalTransaksi,
            'tgl_transaksi' => Carbon::now(),
        ]);

        $transaksi = Transaksi::create($transaksiData);

        // Simpan data transfer/DP sesuai metode
        if ($request->metode_transaksi == 'transfer') {
            $transferData = $request->only([
                'bank_pengirim',
                'nama_pengirim',
                'no_rekening_pengirim',
                'bukti_transfer',
                'tgl_transfer'
            ]);
            $transferData['id_transaksi'] = $transaksi->id_transaksi;
            Transfer::create($transferData);
        } elseif ($request->metode_transaksi == 'DP') {
            $dpData = $request->only([
                'jumlah_dp',
                'bank_pengirim',
                'nama_pengirim',
                'no_rekening_pengirim',
                'bukti_dp',
                'tgl_dp'
            ]);
            $dpData['id_transaksi'] = $transaksi->id_transaksi;
            Dp::create($dpData);
        }

        KeuanganService::simpanPendapatan(
            $transaksi->id_transaksi,
            $produk->id_produk,
            $totalTransaksi
        );

        return response()->json([
            'message' => 'Transaksi berhasil dibuat',
            'transaksi' => $transaksi
        ], 201);
    });
}


    public function show($id)
    {
        $transaksi = Transaksi::with(['transfer', 'dp'])->findOrFail($id);
        return response()->json($transaksi);
    }
}
