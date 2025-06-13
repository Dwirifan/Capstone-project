<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;


class KeranjangController extends Controller
{
    public function keranjang(Request $request)
    {
        $userId = $request->user()->id_user;

        $items = Keranjang::with('produk')
            ->where('id_user', $userId)
            ->get();

        return response()->json($items);
    }
    public function tambahkeranjang(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
        ]);

        $userId = $request->user()->id_user;

        $keranjang = Keranjang::where('id_user', $userId)
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($keranjang) {
            $keranjang->increment('jumlah', $request->jumlah);
            $keranjang->refresh();
            $status = 200;
        } else {
            $keranjang = Keranjang::create([
                'id_user' => $userId,
                'id_produk' => $request->id_produk,
                'jumlah' => $request->jumlah,
            ]);
            $status = 201;
        }

        return response()->json([
            'message' => 'Berhasil ditambahkan ke keranjang',
            'data' => $keranjang,
        ], $status);
    }


    public function destroy($id)
    {
        $item = Keranjang::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item dihapus']);
    }
}

