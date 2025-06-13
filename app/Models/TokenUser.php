<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenUser extends Model
{
    protected$table = 'token_user';
    protected $fillable = [
        'user_id',
        'token',
        'ip_address',
        'user_agent',
        'is_revoked'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
