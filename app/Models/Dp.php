<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dp extends Model
{
    use HasFactory;

    protected $table = 'dp';

    protected $fillable = [
        'id_transaksi',
        'jumlah_dp',
        'bank_pengirim',
        'nama_pengirim',
        'no_rekening_pengirim',
        'bukti_dp',
        'tgl_dp',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}
