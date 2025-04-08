@component('mail::message')
# Your OTP Verification Code

Your one-time password (OTP) is: 

@component('mail::panel')
{{ $otp }}
@endcomponent

This code will expire in 5 minutes.

Thanks,<br>
{{ config('app.name') }}
@endcomponent