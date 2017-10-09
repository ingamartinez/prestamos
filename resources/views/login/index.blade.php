<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Flat Login Form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">


</head>

<body>

<div class="container">
    <div class="info">
        <h1>Prestamos UniSINU</h1>
        {{--<span>Made with <i class="fa fa-heart"></i> by <a href="http://andytran.me">Andy Tran</a></span>--}}
    </div>
</div>
<div class="form">
    <div class="thumbnail"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/hat.svg"/></div>
    @include('flash::message')

    <form class="login-form" action="{{route('login.store')}}" method="POST" autocomplete="off" id="form_login">
        {{method_field('POST')}}
        {{csrf_field()}}
        <input type="text" name="email" id="email" placeholder="Correo Electronico"/>
        <input type="password" name="password" id="password" placeholder="Contraseña"/>
        <input class="submit" type="submit" value="Entrar" />
    </form>

</div>

<video id="video" autoplay="autoplay" loop="loop" poster="polina.jpg">
    <source src="http://andytran.me/A%20peaceful%20nature%20timelapse%20video.mp4" type="video/mp4"/>
</video>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/js/index.js')}}"></script>

<script src="{{asset('assets/js/sha3.min.js')}}"></script>

<script>
    $('#form_login').on('submit',function (e) {
        e.preventDefault();
        $('#password').val(sha3_256($('#password').val()));
        this.submit();
    })
</script>

</body>
</html>
