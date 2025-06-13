<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileProduk extends Model
{
     use HasFactory;

    protected $table = 'file_produk';

    protected $fillable = [
        'id_produk',
        'tipe_file',
        'file_path',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}

