<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $guarded=['id'];
       public function getIconAttribute($value)
    {
        return asset('uploads/aboutus') . "/" . $value;
    }
}
