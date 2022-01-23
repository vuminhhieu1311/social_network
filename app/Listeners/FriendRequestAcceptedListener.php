<?php

namespace App\Listeners;

use App\Events\FriendRequestAcceptedEvent;
use App\Notifications\FriendRequestAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class FriendRequestAcceptedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FriendRequestAcceptedEvent  $event
     * @return void
     */
    public function handle(FriendRequestAcceptedEvent $event)
    {
        $event->user->notify(new FriendRequestAccepted(Auth::user()));
    }
}
