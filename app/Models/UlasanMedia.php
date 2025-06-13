<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UlasanMedia extends Model
{
    protected $table = 'ulasan_media';
    protected $primaryKey = 'id_ulasan_media';
    protected $guarded = [];
    public function getFilePathUrlAttribute()
    {
        if ($this->file_path) {
            return Storage::disk('public')->url($this->file_path);
        }
        return null;
    }
}
