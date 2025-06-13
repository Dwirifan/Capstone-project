<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    protected $table = 'produksi';
    protected $primaryKey = 'id_produksi';
    protected $fillable = [
        'id_panen',
        'tgl_pengemasan',
        'metode_pembersihan',
        'kondisi_penyimpanan',
    ];

     public function beras()
    {
        return $this->hasOne(Beras::class, 'id_produksi', 'id_produksi');
    }
     public function panen()
    {
        return $this->belongsTo(Panen::class, 'id_panen', 'id_panen');
    }
}
