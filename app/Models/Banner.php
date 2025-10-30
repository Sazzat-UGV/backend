<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class Banner extends Model
{
    protected $guarded = ['id'];
    public function getImageAttribute($iamge)
    {
        return asset('uploads/banner/' . $iamge);
    }
public function getIsActiveAttribute($value)
{
    return (bool) $value;
}

}
