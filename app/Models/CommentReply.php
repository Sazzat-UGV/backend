<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    protected $guarded = ['id'];

    public function reactions()
    {
        return $this->hasMany(CommentReplyReaction::class, 'comment_reply_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
