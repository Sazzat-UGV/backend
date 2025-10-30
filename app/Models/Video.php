<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = ['id'];
    public function getVideoAttribute($video)
    {
        return asset('uploads/video/' . $video);
    }
    public function getThumbnailAttribute($thumbnail)
    {
        return asset('uploads/thumbnail/' . $thumbnail);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function likes()
    {
        return $this->hasMany(LikedVideo::class);
    }
    public function dislikes()
    {
        return $this->hasMany(DislikedVideo::class);
    }
    public function watch_histories()
    {
        return $this->hasMany(WatchHistory::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function commentReplies()
    {
        return $this->hasManyThrough(CommentReply::class, Comment::class);
    }
    public function reply()
    {
        return $this->hasManyThrough(
            CommentReply::class,
            Comment::class,
            'video_id',
            'comment_id',
            'id',
            'id'
        );
    }
    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }
}
