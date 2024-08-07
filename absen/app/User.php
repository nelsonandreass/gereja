<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','nomor_telepon','alamat','barcode','kartu','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function absen(){
        return $this->belongsTo(Absen::class,'kartu','user_id');
    }

    public function komsel(){
        return $this->belongsTo(KomselMember::class,'id','user_id');
    }

    public function bic(){
        return $this->hasOne(Bic::class,'user_id','kartu');
    }

    public function keluarga(){
        return $this->belongsTo(Keluarga::class,"id","anggota_id");
    }
}
