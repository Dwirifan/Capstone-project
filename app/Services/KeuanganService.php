<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Produk;

class KeuanganService
{
    public static function simpanPendapatan($transaksiId, $produkId, $pendapatan)
    {
        $produk = Produk::findOrFail($produkId);

        // Ambil saldo terakhir dari keuangan petani
        $lastSaldo = DB::table('keuangan')
            ->where('id_petani', $produk->id_petani)
            ->orderByDesc('created_at')
            ->value('saldo_setelah') ?? 0;

        // Hitung saldo baru
        $saldoBaru = $lastSaldo + $pendapatan;

        // Simpan transaksi baru ke tabel keuangan
        DB::table('keuangan')->insert([
            'id_petani' => $produk->id_petani,
            'id_transaksi' => $transaksiId,
            'id_produk' => $produkId,
            'jenis' => 'masuk',
            'jumlah' => $pendapatan,
            'saldo_setelah' => $saldoBaru,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
