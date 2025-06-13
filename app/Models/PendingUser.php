<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PendingUser extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'pending_user';
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];
    public $timestamps = true;
}
