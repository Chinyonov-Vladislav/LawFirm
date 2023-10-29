<!Doctype html>
<html lang = "ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Адвокатская фирма - @yield('title')</title>
    <link rel="icon" href="{{asset('photos/favicon.ico')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"  href = "{{asset("css/bootstrap.min.css")}}">
    <!-- Animate CSS -->

    <link rel="stylesheet" href = "{{asset("css/animate.min.css")}}">
    <!-- Meanmenu CSS -->

    <link rel="stylesheet" href = "{{asset("css/meanmenu.min.css")}}">
    <!-- Line Awesome CSS -->

    <link rel="stylesheet" href = "{{asset("css/line-awesome.min.css")}}">
    <!-- Magnific CSS -->

    <link rel="stylesheet" href="{{asset("css/magnific-popup.css")}}">
    <!-- Owl Carousel CSS -->

    <link rel="stylesheet" href = "{{asset("css/owl.carousel.min.css")}}">
    <!-- Owl Theme CSS -->

    <link rel="stylesheet" href = "{{asset("css/owl.theme.default.min.css")}}">
    <!-- Odometer CSS -->

    <link rel="stylesheet" href = "{{asset("css/odometer.css")}}">
    <!-- Stylesheet CSS -->

    <link rel="stylesheet" href = "{{asset("css/style.css")}}">
    <!-- Stylesheet Responsive CSS -->

    <link rel="stylesheet" href = "{{asset("css/responsive.css")}}">

    <link rel="stylesheet"  href = "{{asset("css/app.css")}}">
    <!--
    asset - искать с корня
    defer - отложенная загрузка скрипта -->
</head>
<body>
<!-- для отображения и работы vue-компоненты нужно помещать в div id = "app" -->
<div id="app" class="d-flex flex-column min-vh-100">
    @yield('content')
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{asset("js/jquery.min.js")}}"></script>
<script src="{{asset("js/bootstrap.bundle.min.js")}}"></script>
<!-- Meanmenu JS -->
<script src="{{asset("js/meanmenu.min.js")}}"></script>
<!-- Magnific JS -->
<script src="{{asset("js/jquery.magnific-popup.min.js")}}"></script>
<!-- Owl Carousel JS -->
<script src="{{asset("js/owl.carousel.min.js")}}"></script>
<!-- Odometer JS -->
<script src="{{asset("js/odometer.min.js")}}"></script>
<!-- Appear JS -->
<script src="{{asset("js/jquery.appear.js")}}"></script>
<!-- Form Validator JS -->
<script src="{{asset("js/form-validator.min.js")}}"></script>
<!-- Contact JS -->
<script src="{{asset("js/contact-form-script.js")}}"></script>
<!-- Ajaxchimp JS -->
<script src="{{asset("js/jquery.ajaxchimp.min.js")}}"></script>
<!-- Custom JS -->
<script src="{{asset("js/custom.js")}}"></script>
</body>
</html>
