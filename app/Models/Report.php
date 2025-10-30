<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
   protected $guarded=['id'];

public function user(){
    return $this->belongsTo(User::class);
}
public function video(){
    return $this->belongsTo(Video::class);
}
public function appeal(){
    return $this->hasOne(Appeal::class);
}
}
