<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
   protected $table = 'panen';
   protected $primaryKey = 'id_panen';
   protected $fillable = [
    'id_lahan',
    'teknik_panen',
    'jenis_pengeringan',
    'durasi_pengeringan',
   ];
    public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'id_lahan', 'id_lahan');
    }
}
