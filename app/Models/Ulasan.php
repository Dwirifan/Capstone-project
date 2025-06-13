<?php

namespace App\Models;

use App\Models\UlasanMedia;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{

    protected $table = 'ulasan';

    protected $primaryKey = 'id_ulasan';

      protected $fillable = [
        'id_user',
        'id_produk',
        'rating',
        'comment',
        'is_edited'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class,'id_produk', 'id_produk');
    }
      public function media()
    {
        return $this->hasMany(UlasanMedia::class, 'id_ulasan', 'id_ulasan');
    }
}

