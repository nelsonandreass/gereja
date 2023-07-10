<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bic extends Model
{

    protected $fillable = [
       'user_id'
    ];

    public function user(){
        return $this->hasOne(User::class,'kartu','user_id');
    }
}
