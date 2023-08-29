<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" theme='lightTheme'>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mindful | @yield('pagename')</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-touch-icon.png') }} ">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }} ">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }} ">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }} ">
    <link rel="mask-icon" href="{{ asset('assets/favicon/safari-pinned-tab.svg') }} " color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#f1f1f1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type='text/css'>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        @media screen and (max-width:786px) {
            /*.desktop-switch-button {*/
            /*    display:none;*/
            /*}*/
        }
    </style>
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar mindfulNevbar navbar-expand-md shadow-sm">
            <div class="container-fluid standard">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo/logo.png') }}" alt=""
                        class="img-fluid showLight top-logo" style='display:none'>
                    <img src="{{ asset('assets/images/logo/logo-dark.png') }}" alt=""
                        class="img-fluid showdark top-logo" style='display:none'>
                </a>


                <div class="collapse navbar-collapse justify-content-md-center" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.main') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.rules') }}">{{ __('Rules') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.settings') }}">{{ __('Settings') }}</a>
                        </li>

                    </ul>
                </div>
                <a href="javascript:void(0)" class="switch-icon-button jjkd desktop-switch-button">
                    <img src="{{ asset('assets/images/svg/moon.svg') }}" class="light ml-2">
                    <img src="{{ asset('assets/images/svg/moonDark.svg') }}" class="dark ml-2">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation"><span class="fa fa-bars"></span></button>


            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @yield('scripts')
    <script>
        var user_id = "{{ @$user->id }}";
        let ip_address = "{{ env('APP_NODE_IP_ADDRESS') }}";
        // const port = process.env.PORT || 3000;
        let socket = io("node.suzukichampionmotors.com");

        socket.on("connection", (socket) => {

        });
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>
</body>

</html>
