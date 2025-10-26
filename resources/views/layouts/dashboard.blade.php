<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="robots" content="noindex, nofollow">
        <title>{{ Str::title($title ?? 'Dashboard Admin') }}</title>

        <!-- Favicon -->
        <x-link type="image/x-icon" href="assets/img/favicon.png" rel="shortcut icon" />

        <!-- Bootstrap CSS -->
        <x-link href="assets/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Datetimepicker CSS -->
        <x-link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />

        <!-- animation CSS -->
        <x-link href="assets/css/animate.css" rel="stylesheet" />

        <x-link href="assets/plugins/material/materialdesignicons.css" rel="stylesheet" />

        @stack('style')
        <!-- Select2 CSS -->
        <x-link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
        <!-- Fontawesome CSS -->
        <x-link href="assets/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet" />
        <x-link href="assets/plugins/fontawesome/css/all.min.css" rel="stylesheet" />

        <!-- Main CSS -->
        <x-link href="assets/css/style.css" rel="stylesheet" />
        <style>
            .ri-spin {
                display: inline-block;
                animation: ri-spin 1s linear infinite;
            }


            @keyframes ri-spin {
                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
        @vite(['resources/css/app.css'])
    </head>

    <body>
        <div id="global-loader">
            <div class="whirly-loader"> </div>
        </div>
        <!-- Main Wrapper -->
        <div class="main-wrapper">

            <!-- Header -->
            @include('__partials.dashboard.header')
            <!-- /Header -->

            <!-- Sidebar -->
            @include('__partials.dashboard.sidebar')
            <!-- /Sidebar -->

            <div class="page-wrapper">
                <div class="content">
                    {{ $slot }}
                </div>
            </div>

            {{ $modal ?? '' }}

        </div>
        <!-- /Main Wrapper -->

        <!-- jQuery -->
        <x-script src="assets/js/jquery-3.7.1.min.js"></x-script>

        <!-- Feather Icon JS -->
        <x-script src="assets/js/feather.min.js"></x-script>

        <!-- Slimscroll JS -->
        <x-script src="assets/js/jquery.slimscroll.min.js"></x-script>

        @stack('script')

        <!-- Bootstrap Core JS -->
        <x-script src="assets/js/bootstrap.bundle.min.js"></x-script>
        <!-- Chart JS -->
        <x-script src="assets/plugins/apexchart/apexcharts.min.js"></x-script>
        <x-script src="assets/plugins/apexchart/chart-data.js"></x-script>

        <!-- Sweetalert 2 -->
        <x-script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></x-script>
        <x-script src="assets/plugins/sweetalert/sweetalerts.min.js"></x-script>

        <!-- Custom JS -->
        <x-script src="assets/js/theme-script.js"></x-script>
        <x-script src="assets/js/script.js"></x-script>

    </body>

</html>
