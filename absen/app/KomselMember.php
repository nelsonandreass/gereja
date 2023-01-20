<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomselMember extends Model
{
    public function komsel(){
        return $this->belongsTo(Komsel::class,'id','user_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function users(){
        return $this->hasMany(User::class,'id','user_id');
    }
}
