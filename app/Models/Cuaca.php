<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuaca extends Model
{
   protected $table = 'cuaca';
   protected $primaryKey = 'id_cuaca';
   protected $fillable = [
    'id_lahan',
    'curah_hujan_harian',
    'intensitas_cahaya_matahari',
   ];
   public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'id_lahan', 'id_lahan');
    }
}
