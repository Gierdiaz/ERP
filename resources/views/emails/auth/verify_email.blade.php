@component('mail::message')
# Verify New User Email Address

A new user has registered on your website and needs email verification.

Name: {{ $user->name }}

Email: {{ $user->email }}

![Avatar]({{ $avatarPath }})

@component('mail::button', ['url' => $verificationUrl])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.

Regards,<br>
{{ config('app.name') }}

@endcomponent
