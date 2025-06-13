<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gabah extends Model
{
    protected $table = 'gabah';
    protected $primaryKey = 'id_gabah';
    protected $fillable = [
        'id_produk',
        'kualitas_gabah',
        'stok_kg',
        'harga_gabah',
        'deskripsi',
        'id_panen'
    ];
public function panen() {
    return $this->belongsTo(Panen::class, 'id_panen', 'id_panen');
}
}
