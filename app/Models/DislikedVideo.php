<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DislikedVideo extends Model
{
    protected $guarded = ['id'];
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
