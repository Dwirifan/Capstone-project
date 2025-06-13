<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_user',
        'id_produk',
        'tgl_transaksi',
        'metode_transaksi',
        'jumlah_barang',
        'harga_item',
        'total_transaksi',
        'status_transaksi',
    ];

    public function transfer()
    {
        return $this->hasOne(Transfer::class, 'id_transaksi');
    }

    public function dp()
    {
        return $this->hasOne(Dp::class, 'id_transaksi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
