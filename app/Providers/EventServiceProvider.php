<?php

namespace App\Providers;

use App\Events\FriendRequestAcceptedEvent;
use App\Events\FriendRequestReceivedEvent;
use App\Events\SomeonePostedEvent;
use App\Listeners\FriendRequestAcceptedListener;
use App\Listeners\FriendRequestReceivedListener;
use App\Listeners\SomeonePostedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SomeonePostedEvent::class => [
            SomeonePostedListener::class,
        ],
        FriendRequestReceivedEvent::class => [
            FriendRequestReceivedListener::class,
        ],
        FriendRequestAcceptedEvent::class => [
            FriendRequestAcceptedListener::class,
        ],
        \App\Events\NewChatMessageEvent::class => [
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
