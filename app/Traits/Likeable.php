<?php

namespace App\Traits;

trait Likeable
{
    public function hasLiked($query)
    {
        return (bool)$query->likes()->where([
            'like' => 1,
            'likeable_id' => $query->id,
            'likeable_type' => get_class($query),
            'user_id' => $this->id,
        ])->count();
    }

    public function hasDisliked($query)
    {
        return (bool)$query->likes()->where([
            'dislike' => 1,
            'likeable_id' => $query->id,
            'likeable_type' => get_class($query),
            'user_id' => $this->id,
        ])->count();
    }

    public function changeToDislike($query)
    {
        $likes = $query->likes()->where([
            'like' => 1,
            'dislike' => 0,
            'user_id' => $this->id
        ])->first();
        $likes->like = 0;
        $likes->dislike = 1;
        $likes->update();
    }

    public function changeToLike($query)
    {
        $likes = $query->likes()->where([
            'dislike' => 1,
            'like' => 0,
            'user_id' => $this->id
        ])->first();
        $likes->like = 1;
        $likes->dislike = 0;
        $likes->update();
    }

    public function like($query)
    {
        if ($this->id !== $query->user_id && !$this->isFriendWith($query->user_id)) {
            return back();
        }
        if ($this->hasLiked($query)) {
            return back();
        }
        if ($this->hasDisliked($query)) {
            $this->changeToLike($query);

            return back();
        }
        $query->likes()->create([
            'user_id' => $this->id,
            'like' => 1,
        ]);

        return back();
    }

    public function dislike($query)
    {
        if ($this->id !== $query->user_id && !$this->isFriendWith($query->user_id)) {
            return back();
        }
        if ($this->hasDisliked($query)) {
            return back();
        }
        if ($this->hasLiked($query)) {
            $this->changeToDislike($query);

            return back();
        }
        $query->likes()->create([
            'user_id' => $this->id,
            'dislike' => 1,
        ]);

        return back();
    }
}
