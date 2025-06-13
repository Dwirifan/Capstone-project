<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    protected $table = 'lahan';
    protected $primaryKey = 'id_lahan';
    protected $fillable = [
        'id_petani',
        'lokasi_lahan',
        'latitude',
        'longitude',
        'bentuk_lahan',
        'ukuran_lahan',
        'ph_tanah',
        'ketersediaan_air',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_petani', 'id_user');
    }
}
