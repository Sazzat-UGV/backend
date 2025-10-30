<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $guarded = ['id'];
    public function getIsBannerActiveAttribute($value)
    {
        return (bool) $value;
    }
}
