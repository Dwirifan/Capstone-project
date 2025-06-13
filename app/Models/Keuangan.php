<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_petani',
        'id_transaksi',
        'id_produk',
        'jenis',
        'jumlah',
        'saldo_setelah',
    ];

    public function petani()
    {
        return $this->belongsTo(User::class, 'id_petani', 'id_user');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
