
@component('mail::message')
# Forget Password

Please Use this temporary password to login. 
Your temporary password is {{$password}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
