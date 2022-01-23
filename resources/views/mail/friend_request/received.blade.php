@component('mail::message')
# Friend Request Received

You have received a friend request from {{ $user->name }}.

@component('mail::button', ['url' => route('profiles.show', $user->profile->id)])
View Request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
