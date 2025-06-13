<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    protected $table = 'pembeli';
    protected $primaryKey = 'id_user';
    public $incrementing = false;

    protected $fillable = [
        'id_user',
        'username',
        'foto_pembeli',
        'tgl_lahir',
        'no_hp',
        'alamat',
    ];
}
