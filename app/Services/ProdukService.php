<?php

namespace App\Services;

use App\Models\Produk;
use Illuminate\Validation\ValidationException;

class ProdukService
{
    public static function cekDanKurangiStok(Produk $produk, int $jumlah)
    {
        if ($produk->tipe_produk === 'beras' && $produk->beras) {
            if ($produk->beras->stok_kg < $jumlah) {
                throw ValidationException::withMessages([
                    'jumlah_barang' => 'Stok beras tidak mencukupi. Sisa stok: ' . $produk->beras->stok_kg . ' kg',
                ]);
            }
            $produk->beras->decrement('stok_kg', $jumlah);
        } elseif ($produk->tipe_produk === 'gabah' && $produk->gabah) {
            if ($produk->gabah->stok_kg < $jumlah) {
                throw ValidationException::withMessages([
                    'jumlah_barang' => 'Stok gabah tidak mencukupi. Sisa stok: ' . $produk->gabah->stok_kg . ' kg',
                ]);
            }
            $produk->gabah->decrement('stok_kg', $jumlah);
        } elseif ($produk->tipe_produk === 'tebas' && $produk->tebas) {
            if ($produk->tebas->stock_produk !== 'available') {
                throw ValidationException::withMessages([
                    'id_produk' => 'Produk tebasan ini sudah terjual atau tidak tersedia.',
                ]);
            }
            if ($jumlah != 1) {
                throw ValidationException::withMessages([
                    'jumlah_barang' => 'Pembelian produk tebasan hanya bisa 1 unit per transaksi.',
                ]);
            }
            $produk->tebas->update(['stock_produk' => 'sold']);
        }

        $produk->increment('jumlah_penjualan', $jumlah);
    }
}
