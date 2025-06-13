<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function saldo()
    {
        $userId = auth()->id();

        $latest = Keuangan::where('id_petani', $userId)
            ->latest('created_at')
            ->first();

        return response()->json([
            'saldo_terakhir' => $latest ? $latest->saldo_setelah : 0
        ]);
    }

    public function totalPendapatan()
    {
        $userId = auth()->id();

        $total = Keuangan::where('id_petani', $userId)
            ->where('jenis', 'masuk')
            ->sum('jumlah');

        return response()->json([
            'total_pendapatan' => $total
        ]);
    }

    public function pendapatanPerBulan(Request $request)
    {
        $userId = auth()->id();
        $tahun = intval($request->input('tahun', now()->year)); 

        $data = Keuangan::selectRaw('MONTH(created_at) as bulan, SUM(jumlah) as total')
            ->where('id_petani', $userId)
            ->where('jenis', 'masuk')
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('bulan')
            ->get();

        return response()->json([
            'tahun' => $tahun,
            'data' => $data
        ]);
    }

    public function riwayat()
    {
        $userId = auth()->id();

        $riwayat = Keuangan::with(['produk:id_produk,nama'])
            ->where('id_petani', $userId)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($riwayat);
    }
}
