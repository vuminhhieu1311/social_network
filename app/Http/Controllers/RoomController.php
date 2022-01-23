<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessageEvent;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function index()
    {
        return Inertia::render('User/ChatRoom/Index', [
            'rooms' => Room::all(),
        ]);
    }

    public function store(Request $request, Room $room)
    {
        $message = $room->messages()->create([
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);
        broadcast(new NewChatMessageEvent($message, Auth::user()))->toOthers();

        return back();
    }

    public function show(Room $room)
    {
        $messages = Message::where('room_id', $room->id)
            ->with('user')->oldest()->get();

        return Inertia::render('User/ChatRoom/Show', [
            'room' => $room,
            'messages' => $messages,
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $room->active = $request->count;
        $room->update();

        return back();
    }
}
