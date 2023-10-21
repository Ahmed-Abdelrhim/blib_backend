
@component('mail::message')
# Password Reset OTP

Please Use this OTP to Reset Your Password. 
Your OTP is {{$otp}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
