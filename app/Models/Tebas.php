<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tebas extends Model
{
    protected $table = 'tebas';
    protected $primaryKey = 'id_tebas';
    protected $fillable = [
        'id_produk',
        'umur_padi',
        'rendeman_padi',
        'stok_produk',
        'harga',
        'deskripsi'
    ];

    public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'id_lahan', 'id_lahan');
    }

}
