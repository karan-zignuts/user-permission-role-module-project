
@component('mail::message')
# Hello {{ $user->first_name }} {{ $user->last_name }} ,

You have been invited to join our platform. Click the link below to accept the invitation:

@component('mail::button', ['url' => route('acceptinvite', ['token' => $token])])
Accept Invitation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
