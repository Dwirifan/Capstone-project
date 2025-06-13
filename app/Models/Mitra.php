<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';
    protected $primaryKey = 'id_petani';
    public $incrementing = false;

    protected $fillable = [
        'id_mitra',
        'username',
        'foto_mitra',
        'tgl_lahir',
        'no_hp',
        'alamat',
        'nomor_rekening',
    ];
}
