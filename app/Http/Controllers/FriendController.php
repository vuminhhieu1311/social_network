<?php

namespace App\Http\Controllers;

use App\Events\FriendRequestAcceptedEvent;
use App\Events\FriendRequestReceivedEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FriendController extends Controller
{
    public function index()
    {
        return Inertia::render('User/Friend/Index', [
            'friends' => Auth::user()->friends(),
            'requests' => Auth::user()->pendingRequests(),
        ]);
    }
    public function store(Request $request, User $user)
    {
        if (!$user) {
            return back()->withErrors(['message' => 'This user could not be found']);
        }
        Auth::user()->addFriend($user->id);
        event(new FriendRequestReceivedEvent($user));

        return back();
    }

    public function update(Request $request, User $user)
    {
        if (!$user) {
            return back()->withErrors(['message' => 'This user could not be found']);
        }
        Auth::user()->acceptFriend($user->id);
        event(new FriendRequestAcceptedEvent($user));

        return back();
    }

    public function destroy(User $user)
    {
        if (!$user) {
            return back()->withErrors(['message' => 'This user could not be found']);
        }
        Auth::user()->deleteFriend($user->id);

        return back();
    }

    public function deny(User $user) {
        if (!$user) {
            return back()->withErrors(['message' => 'This user could not be found']);
        }
        Auth::user()->denyFriend($user->id);

        return back();
    }
}
