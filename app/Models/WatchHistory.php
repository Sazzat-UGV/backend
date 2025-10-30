<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    protected $guarded = ['id'];
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
