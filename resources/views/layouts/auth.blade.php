<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

        <title>{{ $title ?? 'Login' }}</title>

        <!-- Favicon -->
        <x-link type="image/x-icon" href="landing/assets/images/favicon/favicon.png" rel="shortcut icon" />

        <!-- Bootstrap CSS -->
        <x-link href="assets/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Fontawesome CSS -->
        <x-link href="assets/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet" />
        <x-link href="assets/plugins/fontawesome/css/all.min.css" rel="stylesheet" />

        <!-- Main CSS -->
        <x-link href="assets/css/style.css" rel="stylesheet" />
        @vite(['resources/js/app.js', 'resources/css/app.css'])

    </head>

    <body class="account-page">

        <x-loader show />

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <div class="account-content">
                <div class="login-wrapper login-new">
                    <div class="container">
                        <div class="login-content user-login">
                            {{-- <div class="login-logo">
                                <x-img src="logo.png" alt="img" />
                                <a class="login-logo logo-white" href="/auth/login">
                                    <x-img src="logo-white.png" alt="" />
                                </a>
                            </div> --}}
                            {{ $slot }}

                        </div>
                        <div class="d-flex justify-content-center align-items-center copyright-text my-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Wrapper -->

        <!-- jQuery -->
        <x-script src="assets/js/jquery-3.7.1.min.js"></x-script>

        <!-- Feather Icon JS -->
        <x-script src="assets/js/feather.min.js"></x-script>

        <!-- Bootstrap Core JS -->
        <x-script src="assets/js/bootstrap.bundle.min.js"></x-script>

        <!-- Custom JS -->
        <x-script src="assets/js/theme-script.js"></x-script>
        <x-script src="assets/js/script.js"></x-script>

    </body>

</html>
