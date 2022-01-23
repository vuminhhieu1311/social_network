<?php

namespace App\Http\Controllers;

use App\Events\SomeonePostedEvent;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use App\Notifications\SomeonePosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        if((Auth::id() !== $request->user_id) && (Auth::user()->isFriendWith($request->user_id))) {
            Post::create([
                'body' => $request->body,
                'parent_id' => $request->user_id,
                'user_id' => Auth::id(),
            ]);
            $user = User::where('id', $request->user_id)->first();
            event(new SomeonePostedEvent($user));

            return back();
        }
        if (Auth::id() === $request->user_id) {
            Auth::user()->posts()->create([
                'body' => $request->body,
            ]);

            return back();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     */
    public function destroy(Post $post)
    {
        $userId = Auth::id();
        if (($userId === $post->user_id) || ($userId === $post->parent_id)) {
            $post->delete();

            return back();
        }

        return back()->withErrors([
            'message' => 'You do not have permission to delete this post',
        ]);
    }
}
