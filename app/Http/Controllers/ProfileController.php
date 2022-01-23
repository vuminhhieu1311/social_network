<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $members = User::notAuthorized()->paginate(10);

        if ($request->wantsJson()) {
            return $members;
        }

        return Inertia::render('User/Profile/Index', [
            'users' => $members,
        ]);
    }

    public function show(Request $request, Profile $profile)
    {
        $user = $profile->user;
        $posts = Post::where('parent_id', $user->id)
            ->orWhere('user_id', $user->id)
            ->where('parent_id', null)
            ->latest()->paginate(2);

        if ($request->wantsJson()) {
            return $posts;
        }

        return Inertia::render('User/Profile/Show', [
            'userProfile' => $user,
            'posts' => $posts,
            'isFriendWith' => Auth::user()->isFriendWith($user->id),
            'hasPendingRequestFrom' => Auth::user()->hasPendingRequestFrom($user->id),
            'hasPendingSentRequestTo' => Auth::user()->hasPendingSentRequestTo($user->id),
        ]);
    }
}
