<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfer';

    protected $fillable = [
        'id_transaksi',
        'bank_pengirim',
        'nama_pengirim',
        'no_rekening_pengirim',
        'bukti_transfer',
        'tgl_transfer',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}
