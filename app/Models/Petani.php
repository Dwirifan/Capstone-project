<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petani extends Model
{
    protected $table = 'petani';
    protected $primaryKey = 'id_petani';
    public $incrementing = false; 

    protected $fillable = [
        'id_petani',
        'username',
        'tgl_lahir',
        'foto_petani',
        'no_hp',
        'alamat',
        'nomor_rekening',
    ];
}
