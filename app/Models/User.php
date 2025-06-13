<?php

namespace App\Models;

use App\Models\History;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'name',
        'google_id',
        'email',
        'password',
        "role",
        'email_verified_at',
    ];
    protected $dates = [
        'email_verified_at',
    ];
    protected $hidden = ['password', 'token'];

    public function petani()
    {
        return $this->hasOne(Petani::class, 'id_user', 'id_user');
    }
    public function pembeli()
    {
        return $this->hasOne(Pembeli::class, 'id_user', 'id_user');
    }
    public function mitra()
    {
        return $this->hasOne(Mitra::class, 'id_user', 'id_user');
    }
    public function token_user()
    {
        return $this->hasOne(TokenUser::class, 'id_user', 'id_user');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }
    public function history()
    {
        return $this->hasMany(History::class, 'id_user', 'id_user')->latest()->limit(3);
    }

}
