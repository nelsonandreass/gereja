<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komsel extends Model
{
    public function komselmembers(){
        return $this->hasMany(komselmembers::class,'id','user_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
