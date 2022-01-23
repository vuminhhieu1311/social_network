<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        return Auth::user()->like($comment);
    }

    public function destroy(Comment $comment)
    {
        return Auth::user()->dislike($comment);
    }
}
