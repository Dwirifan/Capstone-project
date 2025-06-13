<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
     protected $table = 'history';
    protected $fillable = [
        'id_user', 
        'query', 
        'searched_from', 
        'searched_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
