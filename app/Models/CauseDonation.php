<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CauseDonation extends Model
{
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cause(){
        return $this->belongsTo(Cause::class);
    }
}
