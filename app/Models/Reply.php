<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded=['id'];
    public function comment(){
        return $this->belongsTo(Comment::class);
    }
}
