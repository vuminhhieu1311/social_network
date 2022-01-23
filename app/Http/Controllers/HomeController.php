<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::allPosts()->latest()->paginate(5);
        $suggestedUsers = User::suggested()->take(5)->inRandomOrder()->get();

        if ($request->wantsJson()) {
            return $posts;
        }

        return Inertia::render('Dashboard', [
            'posts' => $posts,
            'suggestedUsers' => $suggestedUsers,
        ]);
    }
}
