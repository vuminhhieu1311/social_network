<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function store(Request $request, $id)
    {
        $notification = Auth::user()->unreadNotifications->find($id);

        return $notification->markAsRead();
    }

    public function update(Request $request)
    {
        $notifications = Auth::user()->unreadNotifications;
        $notifications->markAsRead();

        return back();
    }

    public function destroy($id)
    {
        $notification = Auth::user()->notifications->find($id);
        $notification->delete();

        return back();
    }
}
