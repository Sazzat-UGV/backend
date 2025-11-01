<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded=["id"];

    /* relationship with role */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('role_id');
    }

    /* relationship with module */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
