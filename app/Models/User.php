<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
        'wilayah_id',
        'alamat',
        'nohp',
        'foto',
        'ktp',
        'validate',
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Wilayah()
    {
        return $this->belongsTo( Wilayah::class, 'wilayah_id' );
    }

    public function Orders()
    {
        return $this->hasMany(Order::class);
    }
}
