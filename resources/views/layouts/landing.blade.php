<!DOCTYPE html>
<html lang="en">

    <!-- Mirrored from 7oroof.com/demos/wastia/home-classic.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 Oct 2025 19:10:58 GMT -->

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <x-link href="landing/assets/images/favicon/favicon.png" rel="icon" />
        <title>{{ $title ?? config('app.name', 'Pelaporan Sampah') }}</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;700&family=Roboto:wght@400;700&display=swap"
            rel="stylesheet"
        >
        <link href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" rel="stylesheet">
        <x-link href="landing/assets/css/libraries.css" rel="stylesheet" />
        <x-link href="landing/assets/css/icons.css" rel="stylesheet" />
        <x-link href="landing/assets/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <div class="wrapper">
            <div class="preloader">
                <div class="loading"><span></span><span></span><span></span><span></span></div>
            </div>

            @include('__partials.landing.header')

            {{ $slot }}

            @include('__partials.landing.footer')

        </div><!-- /.wrapper -->

        <x-script src="landing/assets/js/jquery-3.5.1.min.js"></x-script>
        <x-script src="landing/assets/js/plugins.js"></x-script>
        <x-script src="landing/assets/js/main.js"></x-script>
    </body>

</html>
