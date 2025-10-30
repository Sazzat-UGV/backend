<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reactions()
    {
        return $this->hasMany(CommentReaction::class);
    }
    public function reply()
    {
        return $this->hasMany(CommentReply::class);
    }
}
