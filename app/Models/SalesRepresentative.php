<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesRepresentative extends Model
{
    protected $guarded = ['id'];

    public function getPhotoAttribute($image)
    {
        return asset('uploads/representative/' . $image);
    }
    public function users(){
        return $this->hasMany(User::class);
    }
}
