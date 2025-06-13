<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beras extends Model
{
    protected $table = 'beras';
    protected $primaryKey = 'id_beras';
    protected $fillable = [
        'id_produk',
        'kualitas_beras',
        'harga_kg',
        'stok_kg',
        'id_produksi',
        'deskripsi'
    ];
    public function produksi() {
    return $this->belongsTo(Produksi::class, 'id_produksi', 'id_produksi');
}

}
