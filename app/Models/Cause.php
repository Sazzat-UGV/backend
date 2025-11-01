<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cause extends Model
{
    /** @use HasFactory<\Database\Factories\CauseFactory> */
    use HasFactory;

    protected $guarded=['id'];
}
