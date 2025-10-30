<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
     protected $guarded = ["id"];

     public function cities(){
        return $this->hasMany(City::class);
     }
}
