<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function store(Post $post)
    {
        return Auth::user()->like($post);
    }

    public function destroy(Post $post)
    {
        return Auth::user()->dislike($post);
    }
}
