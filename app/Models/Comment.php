<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'body',
    ];

    protected $with = [
        'user',
    ];

    protected $appends = [
        'liked',
        'disliked',
    ];

    public function getLikedAttribute()
    {
        return $this->likes()->where([
            'like' => 1,
            'likeable_id' => $this->id,
            'likeable_type' => get_class($this)
        ])->count();
    }

    public function getDislikedAttribute()
    {
        return $this->likes()->where([
            'dislike' => 1,
            'likeable_id' => $this->id,
            'likeable_type' => get_class($this)
        ])->count();
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
