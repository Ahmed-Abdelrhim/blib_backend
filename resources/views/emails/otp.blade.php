
@component('mail::message')
# Verify Your Email

Please Use this OTP to Verfiy Your Email. 
Your OTP is {{$otp}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
