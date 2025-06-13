<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_petani',
        'tipe_produk',
        'rating',
        'nama',
    ];

    public function beras()
    {
        return $this->hasOne(Beras::class, 'id_produk', 'id_produk');
    }
    public function tebas()
    {
        return $this->hasOne(Tebas::class, 'id_produk', 'id_produk');
    }
    public function gabah()
    {
        return $this->hasOne(Gabah::class, 'id_produk', 'id_produk');
    }
public function file_produk()
{
    return $this->hasOne(FileProduk::class, 'id_produk', 'id_produk')->where('tipe_file', 'foto');
}
public function detailfile()
{
    return $this->hasMany(FileProduk::class, 'id_produk', 'id_produk');
}



    public function petani()
    {
        return $this->belongsTo(Petani::class, 'id_petani', 'id_petani');
    }
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }
}
