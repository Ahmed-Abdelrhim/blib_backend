<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blip</title>
</head>

<body>
    {{-- <p>Hi <b> [Employee Name]</b>! </p> --}}
    <p>Hi <b> {{$name}}</b>! </p>
    <p>This is you login temporary password <b>{{$temporary_password}}</b> </p>
    {!! $email_body !!}
    <p>If you want to sign in, please click on the following download links:</p>
    <p>IOS: <b>[Link IOS] </b> </p>
    <p> Android: <b> [Link Android] </b></p>
    <p>Enjoy! </p>
    <p>Best,</p>
    <p>The Blip team</p>

</body>

</html>
