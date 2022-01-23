@component('mail::message')
    # Friend Request Accepted

    Your friend request has been accepted by {{ $user->name }}.

    @component('mail::button', ['url' => route('profiles.show', $user->profile->id)])
        View Profile
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
