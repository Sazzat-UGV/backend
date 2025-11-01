<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded=["id"];


    /* relationship with user */
    public function user()
    {
        return $this->hasMany(User::class);
    }

    /* relationship with permission */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
