<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public static function getByName($name, $default = null)
    {
        $setting = Self::where("name", $name)->first();
        if (isset($setting)) {
            return $setting->value;
        } else {
            return $default;
        }
    }
}
