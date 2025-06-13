<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanian extends Model
{
    protected $table = 'pertanian';
    protected $primaryKey = 'id_pertanian';
    protected $fillable = [
        'id_lahan',
        'tgl_tanam',
        'metode_tanam',
        'jenis_pupuk',
        'dosis_pupuk_HA',
        'jumlah_gabah_percabang',
        'presentase_gabah_isi_hampa'

    ];
    public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'id_lahan', 'id_lahan');
    }
}
