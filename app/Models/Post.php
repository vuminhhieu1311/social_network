<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'body',
    ];

    protected $with = [
        'user',
        'comments',
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

    public function scopeAllPosts($query)
    {
        return $query->where('user_id', Auth::id())
            ->orWhereIn('user_id', Auth::user()->friendIds());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
