<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $guarded = ['id'];
    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }
    public function getLinksAttribute($value)
    {
        return json_decode($value);
    }
}
