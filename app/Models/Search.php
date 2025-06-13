<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
   protected $table = 'search_history_user';
   protected $fillable = [
    'id_user',
    'query'
   ];

   public function user (){
    return $this->belongsTo(User::class, 'id_user', 'id_user');
   }
}
